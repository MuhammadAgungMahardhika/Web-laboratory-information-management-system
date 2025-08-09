<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Enums\QuotationStatusEnum;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Quotation;
use App\Services\QuotationService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ViewQuotation extends ViewRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
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
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Submitted);
                        Notification::make()->title('Status penawaran telah dikirimkan!')->success()->send();
                        return redirect()->to(QuotationResource::getUrl('view', ['record' => $record->refresh()]));
                    }),
                Action::make('Penawaran disetujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Quotation $record): bool => in_array($record->status, [
                        QuotationStatusEnum::Submitted->value,
                    ]))
                    ->requiresConfirmation()
                    ->action(function (Quotation $record, QuotationService $quotationService) {
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Accepted);
                        Notification::make()->title('Status penawaran telah disetujui!')->success()->send();
                        return redirect()->to(QuotationResource::getUrl('view', ['record' => $record->refresh()]));
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
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Revised);
                        Notification::make()->title('Status penawaran direvisi.')->info()->send();
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
                        $quotationService->updateQuotationStatus($record, QuotationStatusEnum::Cancelled);
                        Notification::make()->title('Status penawaran ditolak.')->danger()->send();
                        return redirect()->to(QuotationResource::getUrl('view', ['record' => $record->refresh()]));
                    }),
            ])
                ->label('Update Status') // Label untuk tombol dropdown utama
                ->icon('heroicon-o-arrow-path')
                ->button()
                ->color('primary'),

        ];
    }
}
