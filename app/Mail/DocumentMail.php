<?php

namespace App\Mail;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment; // Import Attachment
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DocumentMail extends Mailable implements \Illuminate\Contracts\Queue\ShouldQueue
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $markdownView;
    public array $mailData;
    public array $attachmentsData; // Array for attachments
    public int $notifierId; // Properti untuk menyimpan ID user yang memicu email

    // Properti khusus queue jika diperlukan
    public int $tries = 3;    // Coba ulang email hingga 3 kali jika gagal
    public int $backoff = 30; // Tunggu 30 detik sebelum coba ulang
    /**
     * Create a new message instance.
     *
     * @param string $subject Subject of the email
     * @param string $markdownView Blade view for the email body (e.g., 'emails.document')
     * @param array $viewData Data to pass to the Markdown view
     * @param array $attachments Array of arrays: ['content' => ..., 'name' => ..., 'mime' => ...]
     */
    public function __construct(
        string $subject,
        string $markdownView,
        array $mailData = [],
        array $attachmentsData = [],
        ?int $notifierId = null  // ID user yang memicu email, jika ada
    ) {
        $this->emailSubject = $subject;
        $this->markdownView = $markdownView;
        $this->mailData = $mailData;
        $this->attachmentsData = $attachmentsData;
        $this->notifierId = $notifierId; // Simpan ID user yang memicu email
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: $this->markdownView,
            with: $this->viewData, // Pass dynamic data to the Markdown view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        foreach ($this->attachmentsData as $attachment) {
            $attachments[] = Attachment::fromData(fn() => base64_decode($attachment['content']), $attachment['name'])
                ->withMime($attachment['mime']);
        }
        return $attachments;
    }
    /**
     * Metode ini dipanggil setelah email berhasil dikirim dari antrean.
     * Ideal untuk notifikasi sukses dan membersihkan file temporer.
     */
    public function tack(): void
    {
        Log::info('DEBUG: TACK method called for ' . ($this->mailData['quotationNumber'] ?? 'N/A'));

        // 2. Kirim notifikasi sukses ke user yang memicu aksi
        if ($this->notifierId) {
            $user = User::find($this->notifierId);
            Log::info('Sending success notification to user ID: ' . $this->notifierId);
            if ($user) { // Opsional: Cek izin user
                Notification::make()
                    ->success()
                    ->title('Pengiriman Penawaran Berhasil!')
                    ->body('Penawaran #' . ($this->mailData['quotationNumber'] ?? 'N/A') . ' untuk ' . ($this->mailData['customerName'] ?? 'pelanggan') . ' berhasil dikirim via email.')
                    ->sendToDatabase($user) // Kirim notifikasi ke database user
                    // ->broadcast($user)
                    ->send(); // Kirim notifikasi ke frontend jika menggunakan Livewire atau Echo
            }
        }
    }

    /**
     * Metode ini dipanggil jika email gagal dikirim setelah semua percobaan ulang.
     * Ideal untuk notifikasi kegagalan.
     */
    public function failed(\Throwable $exception): void
    {
        // 1. Hapus file sementara yang gagal dikirim (opsional, mungkin ingin disimpan untuk debug)
        foreach ($this->attachmentsData as $attachment) {
            if (isset($attachment['path']) && Storage::disk('public')->exists($attachment['path'])) {
                Storage::disk('public')->delete($attachment['path']);
                Log::warning("Deleted temporary attachment file after failed email: " . $attachment['path']);
            }
        }

        // 2. Kirim notifikasi kegagalan ke user yang memicu aksi
        if ($this->notifierId) {
            $user = User::find($this->notifierId);
            if ($user) { // Opsional: cek izin user
                Notification::make()
                    ->danger()
                    ->title('Pengiriman Penawaran Gagal!')
                    ->body('Gagal mengirim penawaran #' . ($this->mailData['quotationNumber'] ?? 'N/A') . ' via email. Pesan error: ' . $exception->getMessage())
                    ->sendToDatabase($user) // Kirim notifikasi ke database user
                    ->broadcast($user); // Kirim notifikasi ke frontend jika menggunakan Livewire atau Echo
            }
        }

        // Opsional: Log error lebih detail
        Log::error('Email delivery failed for quotation ' . ($this->mailData['quotationNumber'] ?? 'N/A') . ': ' . $exception->getMessage());
    }
}
