<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Exception;
use Filament\Actions\ActionGroup;
use App\Filament\Resources\LabJobResource;
use App\Filament\Resources\LabJobResource\Actions\LabJobStatusAction;
use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\PositionEnum;
use App\Models\LabJob;
use App\Models\Personel;
use App\Services\LabJobService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class EditLabJob extends EditRecord
{
    protected static string $resource = LabJobResource::class;
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()->using(function () {
                return DB::transaction(function () {
                    try {
                        foreach ($this->record->labJobItems as $labJobItem) {
                            $labJobItem->parameterLabJobItems()->delete();
                            $labJobItem->delete();
                        }
                        foreach ($this->record->labJobPersonels as $labJobPersonels) {
                            $labJobPersonels->delete();
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
            ActionGroup::make([
                // Aksi: Tugaskan Tim PPC
                LabJobStatusAction::startJob(static::getResource()::getUrl('view', ['record' => $this->record->id])),
            ])
                ->label('Update Status') // Label untuk tombol dropdown utama
                ->icon(Heroicon::ArrowUp)
                ->button()
                ->color('success'),
            ActionGroup::make([
                LabJobStatusAction::completeSampling(static::getResource()::getUrl('view', ['record' => $this->record->id]))->after(
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
                ->icon(Heroicon::ArrowUp)
                ->color('success'),
        ];
    }
}
