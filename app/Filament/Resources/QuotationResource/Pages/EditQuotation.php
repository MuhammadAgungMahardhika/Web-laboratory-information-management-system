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
                        // Hapus semua data terkait dalam satu transaksi
                        $this->record->quotationItems()->delete();
                        return $this->record->delete();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->danger()
                            ->title('Gagal menghapus lembur')
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
                ->modalWidth('7xl') // Atur lebar modal (misal: '7xl' atau 'full')
                ->modalContent(function (Quotation $record) {
                    // Ini adalah cara untuk me-render Blade view di dalam modal
                    // Gunakan blade view khusus untuk iframe atau langsung iframe di sini
                    $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->quotation_number);
                    $pdfUrl = route('quotations.preview_pdf', $record); // Atau 'quotations.preview_pdf' jika Anda memisahkannya

                    return view('pdfs.preview', [
                        'pdfUrl' => $pdfUrl,
                        'safeFileName' => $safeFileName, // Opsional, jika perlu di view modal
                    ]);
                }),

            Action::make('Download Penawaran')
                ->url(fn(Quotation $record): string => route('quotations.download_pdf', $record))
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary'),
        ];
    }
}
