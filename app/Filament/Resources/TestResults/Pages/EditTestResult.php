<?php

namespace App\Filament\Resources\TestResults\Pages;

use App\Filament\Resources\TestResults\Actions\TestResultAction;
use App\Filament\Resources\TestResults\TestResultResource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditTestResult extends EditRecord
{
    protected static string $resource = TestResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ActionGroup::make([
                TestResultAction::requestValidate($this->getResource()::getUrl('view', ['record' => $this->record->id])),
                TestResultAction::validate($this->getResource()::getUrl('view', ['record' => $this->record->id]))
            ])
                ->label('Update Status')
                ->icon(Heroicon::ArrowUp)
                ->button()
                ->color('success'),

        ];
    }
}
