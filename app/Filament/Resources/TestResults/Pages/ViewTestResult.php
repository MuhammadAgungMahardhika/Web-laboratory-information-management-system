<?php

namespace App\Filament\Resources\TestResults\Pages;

use App\Filament\Resources\TestResults\Actions\TestResultAction;
use App\Filament\Resources\TestResults\TestResultResource;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewTestResult extends ViewRecord
{
    protected static string $resource = TestResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            ActionGroup::make([
                TestResultAction::requestValidate(static::getResource()::getUrl('view', ['record' => $this->record->id])),
                TestResultAction::validate(static::getResource()::getUrl('view', ['record' => $this->record->id])),
                TestResultAction::revisionNeeded(static::getResource()::getUrl('view', ['record' => $this->record->id])),
                TestResultAction::reject(static::getResource()::getUrl('view', ['record' => $this->record->id])),
            ])
                ->label('Update Status')
                ->icon(Heroicon::ArrowUp)
                ->button()
                ->color('success'),
        ];
    }
}
