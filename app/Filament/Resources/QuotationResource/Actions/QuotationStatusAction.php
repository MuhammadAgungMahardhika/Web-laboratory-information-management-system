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

class QuotationStatusAction
{
    public static function submitted(): Action
    {
        return Action::make('Penawaran dikirimkan')
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
            ->schema([
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
                } catch (Exception $e) {
                    // Tangkap error dan tampilkan notifikasi yang ramah pengguna
                    Notification::make()
                        ->title('Gagal revisi penawaran')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    public static function cancelled(): Action
    {
        return  Action::make('Penawaran dibatalkan')
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
                    // Tangkap error dan tampilkan notifikasi yang ramah pengguna
                    Notification::make()
                        ->title('Gagal membatalkan penawaran')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
