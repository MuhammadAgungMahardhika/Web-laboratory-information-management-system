<?php

namespace App\Filament\Resources\TestResults\Pages;

use App\Filament\Resources\TestResults\Actions\TestResultAction;
use App\Filament\Resources\TestResults\TestResultResource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTestResult extends EditRecord
{
    protected static string $resource = TestResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ActionGroup::make([
                // Aksi: Tugaskan Tim PPC
                TestResultAction::sendClarification(static::getResource()::getUrl('view', ['record' => $this->record->id])),
                TestResultAction::validate(static::getResource()::getUrl('view', ['record' => $this->record->id]))
            ])
                ->label('Update Job') // Label untuk tombol dropdown utama
                ->icon('heroicon-o-arrow-path')
                ->button()
                ->color('success'),

        ];
    }
}
