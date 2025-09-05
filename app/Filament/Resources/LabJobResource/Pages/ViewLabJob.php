<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\LabJobResource;
use App\Filament\Resources\LabJobResource\Actions\LabJobStatusAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\ActionGroup;
use Filament\Resources\RelationManagers\RelationManager;

class ViewLabJob extends ViewRecord
{
    protected static string $resource = LabJobResource::class;
    protected $listeners = ['refresh'];
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            LabJobStatusAction::previewReport(),
            LabJobStatusAction::previewTaskLetter(),
            ActionGroup::make([
                LabJobStatusAction::completeSampling()->after(
                    function ($livewire) {
                        $livewire->dispatch('refresh');
                    }
                ),
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
