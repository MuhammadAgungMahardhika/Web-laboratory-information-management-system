<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\LabJobResource;
use App\Filament\Resources\LabJobResource\Actions\LabJobStatusAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\ActionGroup;
use Filament\Support\Icons\Heroicon;

class ViewLabJob extends ViewRecord
{
    protected static string $resource = LabJobResource::class;
    protected $listeners = ['refresh'];
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            ActionGroup::make([
                LabJobStatusAction::previewAnalystTestReport(),
                LabJobStatusAction::previewTaskLetter(),
                LabJobStatusAction::previewLhp(),
            ])->label('Dokumen')
                ->button()
                ->icon(Heroicon::DocumentArrowDown)
                ->color('gray'),
            ActionGroup::make([
                LabJobStatusAction::completeSampling()->after(
                    function ($livewire) {
                        $livewire->dispatch('refresh');
                    }
                ),
                LabJobStatusAction::completeAnalysis(),
                LabJobStatusAction::completeJob(),
                LabJobStatusAction::sendReport(),
                LabJobStatusAction::abortJob(),
            ])
                ->label('Update Status')
                ->button()
                ->icon(Heroicon::ArrowUp)
                ->color('success'),
        ];
    }
}
