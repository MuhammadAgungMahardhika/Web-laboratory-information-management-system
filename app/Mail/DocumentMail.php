<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;
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
use Filament\Notifications\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DocumentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $markdownView;
    public array $mailData;
    public array $attachmentsData; // Array for attachments
    public  $notifierId; // Properti untuk menyimpan ID user yang memicu email

    // Properti khusus queue jika diperlukan
    public int $tries = 3;    // Coba ulang email hingga 3 kali jika gagal
    public int $backoff = 1; // Tunggu 10 detik sebelum coba ulang
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
     * @return array<int, Attachment>
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
     * Metode ini dipanggil jika email gagal dikirim setelah semua percobaan ulang.
     * Ideal untuk notifikasi kegagalan.
     */
    public function failed(Throwable $exception): void
    {

        // 1. Kirim notifikasi kegagalan ke user
        if ($this->notifierId) {
            $user = User::find($this->notifierId);
            if ($user) {
                $quotationNumber = $this->mailData['quotationNumber'] ?? 'N/A';
                $customerName = $this->mailData['customerName'] ?? 'pelanggan';
                $message = 'Gagal mengirim penawaran #' . $quotationNumber . ' untuk ' . $customerName . ' via email. Pesan error: ' . $exception->getMessage();

                Notification::make()
                    ->danger()
                    ->title('Pengiriman Penawaran Gagal!')
                    ->body($message)
                    ->broadcast($user)
                    ->sendToDatabase($user) // Kirim notifikasi ke database user
                    ->send(); // Kirim notifikasi ke frontend jika menggunakan Livewire atau Echo

            }
        }
        // Opsional: Log error lebih detail
        Log::error('Email delivery failed for quotation ' . ($this->mailData['quotationNumber'] ?? 'N/A') . ': ' . $exception->getMessage());
    }
}
