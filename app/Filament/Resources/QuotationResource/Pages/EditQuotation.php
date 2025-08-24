<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Exception;
use Filament\Actions\ActionGroup;
use App\Filament\Resources\QuotationResource;
use App\Filament\Resources\QuotationResource\Actions\QuotationStatusAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;


class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()->using(function () {
                return DB::transaction(function () {
                    try {
                        foreach ($this->record->quotationItems as $quotationItem) {
                            $quotationItem->parameterQuotationItems()->delete();
                            $quotationItem->delete();
                        }
                        return $this->record->delete();
                    } catch (Exception $e) {
                        Notification::make()
                            ->danger()
                            ->title('Gagal menghapus penawaran')
                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                            ->send();
                        return false;
                    }
                });
            }),
            QuotationStatusAction::preview(),
            ActionGroup::make([
                // Tombol "Terima Penawaran"
                QuotationStatusAction::submitted(),
                QuotationStatusAction::accepted(),
                QuotationStatusAction::revised(),
                QuotationStatusAction::cancelled(),
            ])
                ->label('Update Status')
                ->icon('heroicon-o-arrow-path')
                ->button()
                ->color('primary'),

        ];
    }
}
