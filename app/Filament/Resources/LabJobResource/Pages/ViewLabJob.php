<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\LabJobResource;
use App\Filament\Resources\LabJobResource\Actions\LabJobStatusAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\ActionGroup;

class ViewLabJob extends ViewRecord
{
    protected static string $resource = LabJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            LabJobStatusAction::preview(),
            ActionGroup::make([
                LabJobStatusAction::completeSampling(),
                LabJobStatusAction::completeAnalysis(),
                LabJobStatusAction::completeValidation(),
                LabJobStatusAction::generateReport(),
                LabJobStatusAction::approveReport(),
                LabJobStatusAction::sendReport(),
                LabJobStatusAction::abortJob(),
            ])
                ->label('Update Status')
                ->button()
                ->icon('heroicon-o-arrow-path')
                ->color('success'),
        ];
    }
}
