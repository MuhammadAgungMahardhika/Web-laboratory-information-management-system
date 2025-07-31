<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Quotation;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color; // Jika ingin menggunakan warna Filament
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Enums\QuotationStatusEnum;
use App\Mail\DocumentMail;
use App\Services\WhatsAppService;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
            Action::make('Preview Penawaran')
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
                        ->color('primary')
                        ->openUrlInNewTab(), // Buka di tab baru agar tidak mengganggu modal
                ])->modalFooterActionsAlignment('right'), // Atur footer actions ke kanan
            Action::make('Kirim Penawaran')
                ->icon('heroicon-o-paper-airplane')
                ->color(Color::Green)
                ->visible(fn(Quotation $record) => in_array($record->status, [
                    QuotationStatusEnum::Draft->value,
                    QuotationStatusEnum::PendingResponse->value,
                    QuotationStatusEnum::Accepted->value,
                    QuotationStatusEnum::Revised->value,
                ]))
                ->modalHeading('Kirim Penawaran')
                ->form([
                    TextInput::make('customer_whatsapp')
                        ->label('Nomor WhatsApp')
                        ->prefix('+62')
                        ->tel()
                        ->placeholder('8123xxxxxxx')
                        ->default(fn(Quotation $record) => $record->customer->contact_phone_number ?? '')
                        ->required(fn(Get $get) => $get('send_whatsapp')),
                    TextInput::make('customer_email')
                        ->label('Alamat Email')
                        ->email()
                        ->placeholder('customer@example.com')
                        ->default(fn(Quotation $record) => $record->customer->contact_email ?? '')
                        ->required(fn(Get $get) => $get('send_email')),

                    Checkbox::make('send_whatsapp')
                        ->label('Kirim via WhatsApp')
                        ->default(false)
                        ->live(),

                    Checkbox::make('send_email')
                        ->label('Kirim via Email')
                        ->default(true)
                        ->live(),

                    Textarea::make('message')
                        ->label('Pesan Tambahan')
                        ->rows(3)
                        ->placeholder('Tambahkan pesan kustom untuk pelanggan Anda.')
                        ->nullable(),
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
                            $customer->contact_phone_number = $data['customer_whatsapp'];
                            $customer->contact_email = $data['customer_email'];
                            $customer->save();
                        }

                        $record->status = QuotationStatusEnum::PendingResponse->value;
                        $record->save();

                        $record->load(['customer', 'personel', 'quotationItems.parameterQuotationItems']);
                        // HAPUS BARIS INI: $settings = \App\Models\Setting::first();
                        $pdf = Pdf::loadView('pdfs.quotation', ['quotation' => $record]); // Hanya meneruskan quotation
                        $pdfContent = $pdf->output();
                        $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->quotation_number);
                        $base64PdfContent = base64_encode($pdfContent);

                        $publicPdfUrl = route('quotations.download_pdf', $record);

                        if ($data['send_whatsapp']) {
                            // --- Inisialisasi WhatsApp Service ---
                            $whatsAppService = new WhatsAppService();
                            // LOGIKA KIRIM VIA WHATSAPP LANGSUNG (buka link wa.me)
                            $whatsappMessage = "Yth. Bapak/Ibu {$record->customer->name},\n\nTerlampir adalah Penawaran Harga Nomor: *{$record->quotation_number}* dari kami.";
                            if (!empty($data['message'])) {
                                $whatsappMessage .= "\n\nPesan dari pengirim:\n\"{$data['message']}\"";
                            }
                            // Generate link wa.me
                            $directWaLink = $whatsAppService->getWhatsAppDirectLink($data['customer_whatsapp'], $whatsappMessage, $publicPdfUrl);

                            // Notifikasi dengan link WA
                            Notification::make()
                                ->success()
                                ->title('Siap Kirim Penawaran via WhatsApp!')
                                ->body(new HtmlString("Klik <a href='{$directWaLink}' target='_blank' class='underline font-bold'>link ini</a> untuk mengirim WA ke {$data['customer_whatsapp']}."))
                                ->duration(10000) // Tampilkan lebih lama
                                ->send()
                                ->broadcast(Auth::user())
                                ->sendToDatabase(Auth::user());
                        }

                        if ($data['send_email']) {
                            try {

                                Mail::to($data['customer_email'])->send(new DocumentMail(
                                    subject: 'Penawaran Harga #' . $record->quotation_number,
                                    markdownView: 'emails.document',
                                    mailData: [
                                        'title' => 'Penawaran Harga Anda',
                                        'customerName' => $record->customer->name ?? 'Pelanggan',
                                        'message' => $data['message'],
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
                                    notifierId: Auth::id() // ID user yang mengirim
                                ));
                                Notification::make()
                                    ->success()
                                    ->title('Penawaran dalam proses pengiriman via Email')
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
                    });
                })
                ->modalSubmitActionLabel('Kirim')
                ->modalCancelActionLabel('Batal')
                ->slideOver(),
        ];
    }
}
