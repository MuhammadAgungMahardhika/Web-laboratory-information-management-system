<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\LabJobResource;
use App\Models\Enums\JobStatusEnum;
use App\Models\LabJob;
use App\Services\LabJobService;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;

class ViewLabJob extends ViewRecord
{
    protected static string $resource = LabJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('Preview Surat Tugas')
                ->label(fn($record) => $record->labJobPersonels->isNotEmpty() ? 'Preview Surat Tugas' : 'Tidak Ada Surat Tugas')
                ->color(Color::Blue) // Menggunakan warna biru Filament
                ->icon('heroicon-o-eye')
                ->slideOver()
                ->disabled(fn($record) => !$record->labJobPersonels->isNotEmpty())
                ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::InProgress->value)
                ->modalHeading('Pratinjau Surat Tugas')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Tutup Pratinjau')
                ->modalWidth('6xl')
                ->modalContent(function (LabJob $record) {
                    $safeJobNumber = Str::of($record->job_number)->replace('/', '-');
                    $pdfUrl = route('lab_jobs.preview_task_letter', $record);
                    $downloadUrl = route('lab_jobs.download_task_letter', $record);

                    return view('pdfs.preview', [ // Gunakan view modal yang sama
                        'pdfUrl' => $pdfUrl,
                        'safeFileName' => $safeJobNumber,
                        'downloadUrl' => $downloadUrl
                    ]);
                })
                ->modalFooterActions([
                    // Tombol download di footer modal
                    Action::make('Download')
                        ->url(fn(LabJob $record): string => route('lab_jobs.download_task_letter', $record))
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('primary')
                        ->openUrlInNewTab()
                ])
                ->modalFooterActionsAlignment('right'),

            // --- GRUP AKSI UNTUK MENGUBAH STATUS PEKERJAAN LAB ---
            Actions\ActionGroup::make([
                // Aksi: Selesai Sampling
                Action::make('Selesai Sampling')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('info')
                    ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::InProgress->value)
                    ->requiresConfirmation()
                    ->action(function (LabJob $record, LabJobService $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::SamplingCompleted);
                        Notification::make()->title('Status pekerjaan diubah menjadi Sampling Selesai.')->success()->send();
                    }),

                // Aksi: Selesai Analisis
                Action::make('Selesai Analisis')
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('info')
                    ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::SamplingCompleted->value)
                    ->requiresConfirmation()
                    ->action(function (LabJob $record, LabJobService $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::AnalysisCompleted);
                        Notification::make()->title('Status pekerjaan diubah menjadi Analisis Selesai.')->success()->send();
                    }),

                // Aksi: Selesai Validasi
                Action::make('Selesai Validasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('info')
                    ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::AnalysisCompleted->value)
                    ->requiresConfirmation()
                    ->action(function (LabJob $record, LabJobService $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::ValidationCompleted);
                        Notification::make()->title('Status pekerjaan diubah menjadi Validasi Selesai.')->success()->send();
                    }),

                // Aksi: Buat Laporan
                Action::make('Buat Laporan')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('success')
                    ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::ValidationCompleted->value)
                    ->requiresConfirmation()
                    ->action(function (LabJob $record, LabJobService $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::ReportGenerated);
                        Notification::make()->title('Status pekerjaan diubah menjadi Laporan Dibuat.')->success()->send();
                    }),

                // Aksi: Setujui Laporan
                Action::make('Setujui Laporan')
                    ->icon('heroicon-o-document-check')
                    ->color('success')
                    ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::ReportGenerated->value)
                    ->requiresConfirmation()
                    ->action(function (LabJob $record, LabJobService $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::ReportApproved);
                        Notification::make()->title('Status pekerjaan diubah menjadi Laporan Disetujui.')->success()->send();
                    }),

                // Aksi: Kirim
                Action::make('Kirim')
                    ->icon('heroicon-o-truck')
                    ->color('success')
                    ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::Invoiced->value)
                    ->requiresConfirmation()
                    ->action(function (LabJob $record, LabJobService $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::Delivered);
                        Notification::make()->title('Pekerjaan telah selesai dan dikirim.')->success()->send();
                    }),

                // Aksi: Batalkan Pekerjaan
                Action::make('Batalkan Pekerjaan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn(LabJob $record) => $record->status !== JobStatusEnum::Delivered->value && $record->status !== JobStatusEnum::Cancelled->value)
                    ->requiresConfirmation()
                    ->action(function (LabJob $record, LabJobService $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::Cancelled);
                        Notification::make()->title('Pekerjaan telah dibatalkan.')->danger()->send();
                    }),
            ])
                ->label('Update Status')
                ->button()
                ->icon('heroicon-o-arrow-path')
                ->color('success'),
        ];
    }
}
