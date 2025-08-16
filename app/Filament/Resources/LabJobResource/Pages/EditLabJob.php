<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use App\Filament\Resources\LabJobResource;
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
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class EditLabJob extends EditRecord
{
    protected static string $resource = LabJobResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ActionGroup::make([
                // Aksi: Tugaskan Tim PPC
                Action::make('Mulai Pekerjaan')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::PendingStart->value)
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Memulai Pekerjaan')
                    ->modalSubmitActionLabel(function (LabJob $record) {
                        return $record->labJobPersonels->isEmpty() ? 'Ya, Konfirmasi' : 'Ya, Mulai Pekerjaan';
                    })
                    ->modalDescription(function (LabJob $record) {
                        if ($record->labJobPersonels->isEmpty()) {
                            return 'Pekerjaan ini tidak memiliki tim PPC. Anda harus mengonfirmasi bahwa penugasan tidak diperlukan untuk pekerjaan ini.';
                        }
                        return 'Tim PPC sudah ditugaskan. Apakah Anda yakin ingin memulai pekerjaan?';
                    })
                    ->form(function (LabJob $record) {
                        if ($record->labJobPersonels->isEmpty()) {
                            return [
                                Checkbox::make('skip_assignment_confirmation')
                                    ->label('Saya mengonfirmasi bahwa pekerjaan ini tidak membutuhkan penugasan tim PPC.')
                                    ->required()
                            ];
                        }
                        return [];
                    })
                    ->action(function (LabJob $record, LabJobService $labJobService) {
                        try {
                            DB::transaction(function () use ($record, $labJobService) {
                                $labJobService->updateLabJobStatus($record, JobStatusEnum::InProgress);
                            });

                            Notification::make()->title('Pekerjaan telah dimulai.')->success()->send();
                            return redirect()->to(static::getResource()::getUrl('view', ['record' => $record->id]));
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal memulai pekerjaan')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Action::make('Cetak Surat Tugas')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary')
                    // Hanya tampil jika pekerjaan sudah dimulai
                    ->visible(fn(LabJob $record) => $record->job_status === JobStatusEnum::InProgress->value)
                    ->url(fn(LabJob $record): string => route('lab_jobs.download_task_letter', $record))
                    ->openUrlInNewTab(),
            ])
                ->label('Update Job') // Label untuk tombol dropdown utama
                ->icon('heroicon-o-arrow-path')
                ->button()
                ->color('success'),
        ];
    }
}
