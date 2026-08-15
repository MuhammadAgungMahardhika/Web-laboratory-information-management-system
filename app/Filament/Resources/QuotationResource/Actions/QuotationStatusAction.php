<?php

namespace App\Filament\Resources\QuotationResource\Actions;

use App\Filament\Resources\QuotationResource;
use App\Models\Enums\QuotationStatusEnum;
use App\Models\Quotation;
use App\Services\QuotationService;
use Auth;
use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\DocumentMail;
use App\Services\WhatsAppService;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\HtmlString;
use Filament\Support\Colors\Color;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;

class QuotationStatusAction
{

    protected static string $quotationPreviewUrl = 'quotations.preview_pdf';
    protected static string $quotationDownloadUrl = 'quotations.download_pdf';

    public const PERMISSION_PREVIEW_QUOTATION = 'preview-quotation';
    public const PERMISSION_SEND_QUOTATION = 'send-quotation';
    public const PERMISSION_DOWNLOAD_QUOTATION = 'download-quotation';
    public const PERMISSION_SUBMIT_QUOTATION = 'submit-quotation';
    public const PERMISSION_ACCEPT_QUOTATION = 'accept-quotation';
    public const PERMISSION_REVISE_QUOTATION = 'revise-quotation';
    public const PERMISSION_CANCEL_QUOTATION = 'cancel-quotation';

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }
    public static function preview(): Action
    {
        return  Action::make('Preview')
            ->color(Color::Blue) // Menggunakan warna biru Filament
            ->icon(Heroicon::OutlinedDocumentDuplicate)
            ->slideOver()
            ->authorize(static::isAuthorized(static::PERMISSION_PREVIEW_QUOTATION))
            ->modalHeading('Pratinjau Penawaran PDF') // Judul modal
            ->modalSubmitAction(false) // Sembunyikan tombol submit (kita hanya preview)
            ->modalCancelActionLabel('Tutup Pratinjau') // Ubah label tombol cancel
            ->modalWidth('6xl') // Atur lebar modal (misal: '7xl' atau 'full')
            ->modalContent(function (Quotation $record) {
                // Ini adalah cara untuk me-render Blade view di dalam modal
                // Gunakan blade view khusus untuk iframe atau langsung iframe di sini
                $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->code);
                $pdfUrl = route(static::$quotationPreviewUrl, $record);
                $downloadUrl = route(static::$quotationDownloadUrl, $record);

                return view('pdfs.preview', [
                    'pdfUrl' => $pdfUrl,
                    'safeFileName' => $safeFileName, // Opsional, jika perlu di view modal
                    'downloadUrl' => $downloadUrl, // Opsional, jika perlu di view modal
                ]);
            })->modalFooterActions([
                static::download(),
                static::sendQuotation(),
            ])->modalFooterActionsAlignment('right');
    }

    public static function sendQuotation(): Action
    {
        return Action::make('Kirim Penawaran')
            ->authorize(static::isAuthorized(static::PERMISSION_SEND_QUOTATION))
            ->icon('heroicon-o-paper-airplane')
            ->color(Color::Green)
            ->authorize(fn(Quotation $record) => count($record->quotationItems) > 0 && in_array($record->status, [
                QuotationStatusEnum::Draft->value,
                QuotationStatusEnum::Submitted->value,
                QuotationStatusEnum::Revised->value,
            ]))
            ->modalHeading('Proses pengiriman Penawaran')
            ->schema([
                Toggle::make('update_status_to_submitted')
                    ->label('Update status penawaran menjadi terkirim')
                    ->reactive()
                    ->default(true),
                Section::make([
                    Toggle::make('send_whatsapp')
                        ->label('Kirim via WhatsApp')
                        ->default(false)
                        ->reactive(),
                    // Input WhatsApp hanya terlihat jika 'send_whatsapp' di-checklist
                    TextInput::make('customer_whatsapp')
                        ->label('Nomor WhatsApp')
                        ->prefix('+62')
                        ->helperText('Pastikan nomor wa klien benar')
                        ->tel()
                        ->placeholder('8123xxxxxxx')
                        ->default(fn(Quotation $record) => $record->customer->contact_phone_number ?? '')
                        ->required(fn(Get $get) => $get('send_whatsapp'))
                        ->visible(fn(Get $get) => $get('send_whatsapp')),
                ])->columns(2)->heading('Pengiriman Via WhatsApp')->icon('heroicon-o-chat-bubble-left-right'),
                Section::make([
                    // Input Email hanya terlihat jika 'send_email' di-checklist
                    Toggle::make('send_email')
                        ->label('Kirim via Email ?')
                        ->default(true)
                        ->reactive(),
                    TextInput::make('customer_email')
                        ->label('Alamat Email')
                        ->helperText('Pastikan alamat email klien benar')
                        ->email()
                        ->placeholder('customer@example.com')
                        ->default(fn(Quotation $record) => $record->customer->contact_email ?? '')
                        ->required(fn(Get $get) => $get('send_email'))
                        ->visible(fn(Get $get) => $get('send_email')), // <-- Perubahan di sini
                    RichEditor::make('message')
                        ->label('Pesan Email')
                        ->columnSpanFull()
                        ->default(function (Quotation $record) {
                            $customerName = $record->customer->name ?? 'Pelanggan';
                            $quotationNumber = $record->code ?? 'N/A';
                            $quotationName = ucfirst($record->name) ?? 'N/A';
                            $companyName = config('app.name');

                            return "<p>Yth. Bapak/Ibu {$customerName},</p>
                                        <p>Terlampir adalah dokumen penawaran harga terbaru dari kami.</p>
                                        <p>Penawaran ini mencakup rincian sebagai berikut:</p>
                                        <ol>
                                            <li>Nomor Penawaran: <strong>{$quotationNumber}</strong></li>
                                            <li>Judul Penawaran: <strong>{$quotationName}</strong></li>
                                        </ol>
                                        <p>Mohon tinjau dokumen terlampir. Jika ada pertanyaan atau Anda memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami.</p>
                                        <p>Terima kasih atas perhatian Anda.</p>
                                        <p>Hormat kami,<br>
                                        <strong>{$companyName}</strong>";
                        })
                        ->placeholder('Tambahkan pesan Email')
                        ->required(fn(Get $get) => $get('send_email'))
                        ->visible(fn(Get $get) => $get('send_email')),
                ])->columns(2)->heading('Pengiriman Via Email')->icon('heroicon-o-envelope'),
            ])
            ->action(function (array $data, Quotation $record, Action $action) {
                if (!$data['send_whatsapp'] && !$data['send_email']) {
                    Notification::make()
                        ->danger()
                        ->title('Gagal mengirim penawaran')
                        ->body('Pilih setidaknya satu metode pengiriman (WhatsApp atau Email).')
                        ->send();
                    $action->halt();
                }

                DB::transaction(function () use ($data, $record) {
                    $customer = $record->customer;
                    if ($customer) {
                        if (isset($data['customer_whatsapp']) && $data['customer_whatsapp']) {
                            $customer->contact_phone_number = $data['customer_whatsapp'];
                        }
                        if (isset($data['customer_email']) && $data['customer_email']) {
                            $customer->contact_email = $data['customer_email'];
                        }
                        $customer->save();
                    }

                    if ($data['update_status_to_submitted']) {
                        $quotationService = new QuotationService();
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Submitted);
                    }

                    $record->load(['customer', 'personel', 'quotationItems.parameterQuotationItems']);
                    // HAPUS BARIS INI: $settings = \App\Models\Setting::first();
                    $company = Auth::user()->personel?->company;
                    $pdf = Pdf::loadView('pdfs.quotation', ['quotation' => $record, 'company' => $company]); // Hanya meneruskan quotation
                    $pdfContent = $pdf->output();
                    $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->code);
                    $base64PdfContent = base64_encode($pdfContent);

                    $publicPdfUrl = route(static::$quotationDownloadUrl, $record);

                    if ($data['send_whatsapp']) {
                        // --- Inisialisasi WhatsApp Service ---
                        $whatsAppService = new WhatsAppService();
                        // LOGIKA KIRIM VIA WHATSAPP LANGSUNG (buka link wa.me)
                        $whatsappMessage = "Yth. Bapak/Ibu {$record->customer->name},\n\nTerlampir adalah Penawaran Harga Nomor: *{$record->code}* dari kami.";
                        // Remove HTML tags from the message
                        $cleanedMessage = strip_tags($data['message']);

                        if (!empty($cleanedMessage)) {
                            $whatsappMessage .= "\n\nPesan dari pengirim:\n\"{$cleanedMessage}\"";
                        }
                        // Generate link wa.me
                        $directWaLink = $whatsAppService->getWhatsAppDirectLink($data['customer_whatsapp'], $whatsappMessage, $publicPdfUrl);

                        // Notifikasi dengan link WA
                        Notification::make()
                            ->success()
                            ->title('Siap Kirim Penawaran via WhatsApp!')
                            ->body(new HtmlString("Klik <a href='{$directWaLink}' target='_blank' class='underline font-bold'>link ini</a> untuk mengirim Penawaran #{$record->code} melalui Wa ke nomor {$data['customer_whatsapp']}."))
                            ->duration(10000) // Tampilkan lebih lama
                            ->broadcast(Auth::user())
                            ->sendToDatabase(Auth::user())
                            ->send();
                    }

                    if ($data['send_email']) {
                        try {
                            $quotationName = ucfirst($record->name);
                            Mail::to($data['customer_email'])->send(new DocumentMail(
                                subject: 'Penawaran Harga #' . $record->code,
                                markdownView: 'emails.document',
                                mailData: [
                                    'title' => "Penawaran {$quotationName} untuk {$record->customer->name}",
                                    'message' => $data['message'],
                                    'customerName' => $record->customer->name ?? 'Pelanggan',
                                    'quotationNumber' => $record->code, // Tambahkan data spesifik untuk template
                                    'downloadUrl' => route(static::$quotationDownloadUrl, $record),
                                ],
                                attachmentsData: [
                                    [
                                        'content' => $base64PdfContent,
                                        'name' => "Penawaran-{$safeFileName}.pdf",
                                        'mime' => 'application/pdf',
                                    ]
                                ],
                                notifierId: Auth::id()
                            ));
                            Notification::make()
                                ->success()
                                ->title('Proses pengiriman via Email')
                                ->body("Penawaran #{$record->code} dalam proses pengiriman ke {$data['customer_email']}.")
                                ->send();
                        } catch (Exception $e) {
                            Notification::make()
                                ->danger()
                                ->title('Gagal mengirim email penawaran')
                                ->body('Terjadi kesalahan saat mengirim email: ' . $e->getMessage())
                                ->send();
                        }
                    }

                    if ($data['update_status_to_submitted']) {
                        Notification::make()
                            ->success()
                            ->title('Status Penawaran diupdate menjadi Terkirim')
                            ->body("Status Penawaran #{$record->code} berhasil diupdate menjadi Terkirim.")
                            ->send();
                    }
                });
            })
            ->modalSubmitActionLabel('Kirim')
            ->modalCancelActionLabel('Batal')
            ->slideOver();
    }
    public static function download(): Action
    {
        return    Action::make('Download')
            ->authorize(fn(Quotation $record) => count($record->quotationItems) > 0 && static::isAuthorized(static::PERMISSION_DOWNLOAD_QUOTATION))
            ->url(fn(Quotation $record): string => route(static::$quotationDownloadUrl, $record))
            ->icon('heroicon-o-document-arrow-down')
            ->color('info')
            ->openUrlInNewTab();
    }
    public static function submitted(): Action
    {
        return Action::make('Penawaran dikirimkan')
            ->authorize(fn(Quotation $record) =>  in_array($record->status, [
                QuotationStatusEnum::Draft->value,
                QuotationStatusEnum::Revised->value
            ]) && static::isAuthorized(static::PERMISSION_SUBMIT_QUOTATION))
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->action(function (Quotation $record, QuotationService $quotationService) {
                try {
                    DB::transaction(function () use ($record, $quotationService) {
                        // Panggil service untuk mengupdate status dan membuat LabJob
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Submitted);
                    });

                    Notification::make()->title('Status penawaran telah dikirimkan!')->success()->send();
                    return redirect()->to(QuotationResource::getUrl('view', ['record' => $record->refresh()]));
                    // Redirect ke halaman view setelah sukses
                } catch (Exception $e) {
                    // Tangkap error dan tampilkan notifikasi yang ramah pengguna
                    Notification::make()
                        ->title('Gagal mengirimkan penawaran')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengirimkan penawaran', [
                        'quotation_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }

    public static function accepted(): Action
    {
        return  Action::make('Penawaran disetujui')
            ->authorize(static::isAuthorized(static::PERMISSION_ACCEPT_QUOTATION))
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->authorize(fn(Quotation $record): bool =>  in_array($record->status, [
                QuotationStatusEnum::Submitted->value,
                QuotationStatusEnum::Revised->value
            ]))
            // Hapus requiresConfirmation() karena kita akan menggunakan form untuk konfirmasi
            ->modalHeading('Konfirmasi Persetujuan')
            ->modalDescription('Apakah Anda yakin untuk menyetujui penawaran ini? Setelah disetujui, data penawaran tidak dapat diubah lagi dan akan dibuatkan Lab Job.')
            ->modalSubmitActionLabel('Ya, Setujui')
            ->modalCancelActionLabel('Batal')
            // --- Perubahan di sini: Tambahkan form dengan checkbox ---
            ->schema([
                Checkbox::make('acknowledgement')
                    ->label(function () {
                        $personelName = Auth::user()->personel->fullname ?? 'Petugas';
                        return "Saya, {$personelName} memahami bahwa penawaran ini tidak dapat diedit lagi setelah disetujui.";
                    })
                    ->required(),
                Checkbox::make('labJobCreated')
                    ->label(function () {
                        $personelName = Auth::user()->personel->fullname ?? 'Petugas';
                        return "Saya, {$personelName}memahami bahwa ketika penawaran disetujui, akan dibuatkan job untuk pengerjaannya.";
                    })
                    ->required()
            ])
            // --------------------------------------------------------
            ->action(function (Quotation $record, QuotationService $quotationService) {
                try {
                    DB::transaction(function () use ($record, $quotationService) {
                        // Panggil service untuk mengupdate status dan membuat LabJob
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Accepted);
                    });

                    Notification::make()
                        ->title('Status penawaran telah disetujui!')
                        ->body('Penawaran ini disetujui oleh ' . (Auth::user()->personel->full_name ?? 'Petugas') . '.')
                        ->success()
                        ->send();

                    // Redirect ke halaman view setelah sukses
                    return redirect()->to(QuotationResource::getUrl('view', ['record' => $record->refresh()]));
                } catch (Exception $e) {
                    // Tangkap error dan tampilkan notifikasi yang ramah pengguna

                    Notification::make()
                        ->title('Gagal menyetujui penawaran')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal menyetujui penawaran', [
                        'quotation_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }

    public static function revised(): Action
    {
        return  Action::make('Penawaran perlu perbaikan')
            ->authorize(static::isAuthorized(static::PERMISSION_REVISE_QUOTATION))
            ->icon('heroicon-o-pencil-square')
            ->color('info')
            ->authorize(fn(Quotation $record): bool =>  in_array($record->status, [
                QuotationStatusEnum::Submitted->value,
            ]))
            ->requiresConfirmation()
            ->action(function (Quotation $record, QuotationService $quotationService) {
                try {
                    DB::transaction(function () use ($record, $quotationService) {
                        // Panggil service untuk mengupdate status dan membuat LabJob
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Revised);
                    });
                    Notification::make()->title('Status penawaran direvisi.')->info()->send();
                    return redirect()->to(QuotationResource::getUrl('view', ['record' => $record->refresh()]));
                    // Redirect ke halaman view setelah sukses
                } catch (Exception $e) {
                    // Tangkap error dan tampilkan notifikasi yang ramah pengguna

                    Notification::make()
                        ->title('Gagal revisi penawaran')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();

                    Log::error('Gagal revisi penawaran', [
                        'quotation_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }

    public static function cancelled(): Action
    {
        return  Action::make('Penawaran dibatalkan')
            ->authorize(static::isAuthorized(static::PERMISSION_CANCEL_QUOTATION))
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->visible(fn(Quotation $record): bool => in_array($record->status, [
                QuotationStatusEnum::Submitted->value,
            ]))
            ->requiresConfirmation()
            ->action(function (Quotation $record, QuotationService $quotationService) {
                try {
                    DB::transaction(function () use ($record, $quotationService) {
                        // Panggil service untuk mengupdate status dan membuat LabJob
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Cancelled);
                    });
                    Notification::make()->title('Status penawaran ditolak.')->danger()->send();
                    return redirect()->to(QuotationResource::getUrl('view', ['record' => $record->refresh()]));
                    // Redirect ke halaman view setelah sukses
                } catch (Exception $e) {

                    Notification::make()
                        ->title('Gagal membatalkan penawaran')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();

                    Log::error('Gagal membatalkan penawaran', [
                        'quotation_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
}
