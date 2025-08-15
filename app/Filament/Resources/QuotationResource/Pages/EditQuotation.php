<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Quotation;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Enums\QuotationStatusEnum;
use App\Mail\DocumentMail;
use App\Services\QuotationService;
use App\Services\WhatsAppService;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()->using(function () {
                return DB::transaction(function () {
                    try {
                        foreach ($this->record->quotationItems as $quotationItem) {
                            $quotationItem->parameterQuotationItems()->delete();
                            $quotationItem->delete();
                        }
                        return $this->record->delete();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->danger()
                            ->title('Gagal menghapus penawaran')
                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                            ->send();
                        return false;
                    }
                });
            }),
            Action::make('Preview')
                ->color(Color::Blue) // Menggunakan warna biru Filament
                ->icon('heroicon-o-eye')
                ->slideOver()
                ->modalHeading('Pratinjau Penawaran PDF') // Judul modal
                ->modalSubmitAction(false) // Sembunyikan tombol submit (kita hanya preview)
                ->modalCancelActionLabel('Tutup Pratinjau') // Ubah label tombol cancel
                ->modalWidth('6xl') // Atur lebar modal (misal: '7xl' atau 'full')
                ->modalContent(function (Quotation $record) {
                    // Ini adalah cara untuk me-render Blade view di dalam modal
                    // Gunakan blade view khusus untuk iframe atau langsung iframe di sini
                    $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->quotation_number);
                    $pdfUrl = route('quotations.preview_pdf', $record);
                    $downloadUrl = route('quotations.download_pdf', $record);

                    return view('pdfs.preview', [
                        'pdfUrl' => $pdfUrl,
                        'safeFileName' => $safeFileName, // Opsional, jika perlu di view modal
                        'downloadUrl' => $downloadUrl, // Opsional, jika perlu di view modal
                    ]);
                })->modalFooterActions([
                    Action::make('Download')
                        ->url(fn(Quotation $record): string => route('quotations.download_pdf', $record))
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('info')
                        ->openUrlInNewTab(), // Buka di tab baru agar tidak mengganggu modal
                    Action::make('Kirim Penawaran')
                        ->icon('heroicon-o-paper-airplane')
                        ->color(Color::Green)
                        ->visible(fn(Quotation $record) => in_array($record->status, [
                            QuotationStatusEnum::Draft->value,
                            QuotationStatusEnum::Submitted->value,
                            QuotationStatusEnum::Revised->value,
                        ]))
                        ->modalHeading('Proses pengiriman Penawaran')
                        ->form([
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
                                        $quotationNumber = $record->quotation_number ?? 'N/A';
                                        $quotationName = ucfirst($record->quotation_name) ?? 'N/A';
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
                        ->action(function (array $data, Quotation $record, Actions\Action $action) {
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
                                $company = Auth::user()->personel->company;
                                $pdf = Pdf::loadView('pdfs.quotation', ['quotation' => $record, 'company' => $company]); // Hanya meneruskan quotation
                                $pdfContent = $pdf->output();
                                $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->quotation_number);
                                $base64PdfContent = base64_encode($pdfContent);

                                $publicPdfUrl = route('quotations.download_pdf', $record);

                                if ($data['send_whatsapp']) {
                                    // --- Inisialisasi WhatsApp Service ---
                                    $whatsAppService = new WhatsAppService();
                                    // LOGIKA KIRIM VIA WHATSAPP LANGSUNG (buka link wa.me)
                                    $whatsappMessage = "Yth. Bapak/Ibu {$record->customer->name},\n\nTerlampir adalah Penawaran Harga Nomor: *{$record->quotation_number}* dari kami.";
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
                                        ->body(new HtmlString("Klik <a href='{$directWaLink}' target='_blank' class='underline font-bold'>link ini</a> untuk mengirim Penawaran #{$record->quotation_number} melalui Wa ke nomor {$data['customer_whatsapp']}."))
                                        ->duration(10000) // Tampilkan lebih lama
                                        ->broadcast(Auth::user())
                                        ->sendToDatabase(Auth::user())
                                        ->send();
                                }

                                if ($data['send_email']) {
                                    try {
                                        $quotationName = ucfirst($record->quotation_name);
                                        Mail::to($data['customer_email'])->send(new DocumentMail(
                                            subject: 'Penawaran Harga #' . $record->quotation_number,
                                            markdownView: 'emails.document',
                                            mailData: [
                                                'title' => "Penawaran {$quotationName} untuk {$record->customer->name}",
                                                'message' => $data['message'],
                                                'customerName' => $record->customer->name ?? 'Pelanggan',
                                                'quotationNumber' => $record->quotation_number, // Tambahkan data spesifik untuk template
                                                'downloadUrl' => route('quotations.download_pdf', $record),
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
                                            ->body("Penawaran #{$record->quotation_number} dalam proses pengiriman ke {$data['customer_email']}.")
                                            ->send();
                                    } catch (\Exception $e) {
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
                                        ->body("Status Penawaran #{$record->quotation_number} berhasil diupdate menjadi Terkirim.")
                                        ->send();
                                }
                            });
                        })
                        ->modalSubmitActionLabel('Kirim')
                        ->modalCancelActionLabel('Batal')
                        ->slideOver(),
                ])->modalFooterActionsAlignment('right'),

            // --- GRUP AKSI UNTUK STATUS PENAWARAN ---
            Actions\ActionGroup::make([
                // Tombol "Terima Penawaran"
                Action::make('Penawaran dikirimkan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Quotation $record): bool => in_array($record->status, [
                        QuotationStatusEnum::Draft->value,
                        QuotationStatusEnum::Revised->value
                    ]))
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
                        } catch (\Exception $e) {
                            // Tangkap error dan tampilkan notifikasi yang ramah pengguna
                            Notification::make()
                                ->title('Gagal mengirimkan penawaran')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('Penawaran disetujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Quotation $record): bool => in_array($record->status, [
                        QuotationStatusEnum::Submitted->value,
                        QuotationStatusEnum::Revised->value
                    ]))
                    // Hapus requiresConfirmation() karena kita akan menggunakan form untuk konfirmasi
                    ->modalHeading('Konfirmasi Persetujuan')
                    ->modalDescription('Apakah Anda yakin untuk menyetujui penawaran ini? Setelah disetujui, data penawaran tidak dapat diubah lagi dan akan dibuatkan Lab Job.')
                    ->modalSubmitActionLabel('Ya, Setujui')
                    ->modalCancelActionLabel('Batal')
                    // --- Perubahan di sini: Tambahkan form dengan checkbox ---
                    ->form([
                        Checkbox::make('acknowledgement')
                            ->label(function () {
                                $personelName = Auth::user()->personel->fullname ?? 'Petugas';
                                return "Saya **{$personelName}** memahami bahwa penawaran ini tidak dapat diedit lagi setelah disetujui.";
                            })
                            ->required(),
                        Checkbox::make('labJobCreated')
                            ->label(function () {
                                $personelName = Auth::user()->personel->fullname ?? 'Petugas';
                                return "Saya **{$personelName}** memahami bahwa ketika penawaran disetujui, akan dibuatkan job untuk pengerjaannya.";
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
                        } catch (\Exception $e) {
                            // Tangkap error dan tampilkan notifikasi yang ramah pengguna
                            Notification::make()
                                ->title('Gagal menyetujui penawaran')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();

                            // Menghentikan redirect
                            // Jika ada error, Filament akan otomatis tetap di halaman saat ini
                        }
                    }),


                // Tombol "Revisi Penawaran"
                Action::make('Penawaran perlu perbaikan')
                    ->icon('heroicon-o-pencil-square')
                    ->color('info')
                    ->visible(fn(Quotation $record): bool => in_array($record->status, [
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
                        } catch (\Exception $e) {
                            // Tangkap error dan tampilkan notifikasi yang ramah pengguna
                            Notification::make()
                                ->title('Gagal revisi penawaran')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // Tombol "Tolak Penawaran"
                Action::make('Penawaran dibatalkan')
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
                        } catch (\Exception $e) {
                            // Tangkap error dan tampilkan notifikasi yang ramah pengguna
                            Notification::make()
                                ->title('Gagal membatalkan penawaran')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
                ->label('Update Status') // Label untuk tombol dropdown utama
                ->icon('heroicon-o-arrow-path')
                ->button()
                ->color('primary'),

        ];
    }
}
