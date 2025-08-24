<?php

namespace App\Filament\Resources\LabJobResource\Actions;

use App\Filament\Resources\LabJobResource\Actions;
use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\LabJobStatusEnum;
use App\Models\LabJob;
use App\Services\LabJobService;
use Auth;
use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;

class LabJobStatusAction
{

    public static function preview(): Action
    {
        return Action::make('Preview Surat Tugas')
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
            ->modalFooterActionsAlignment('right');
    }
    public static function taskLetter(): Action
    {
        return Action::make('Cetak Surat Tugas')
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            // Hanya tampil jika pekerjaan sudah dimulai
            ->visible(fn(LabJob $record) => $record->job_status === JobStatusEnum::InProgress->value)
            ->url(fn(LabJob $record): string => route('lab_jobs.download_task_letter', $record))
            ->openUrlInNewTab();
    }
    public static function startJob($url): Action
    {
        return Action::make('Mulai Pekerjaan')
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
            ->schema(function (LabJob $record) {
                if ($record->labJobPersonels->isEmpty()) {
                    return [
                        Checkbox::make('skip_assignment_confirmation')
                            ->label('Saya mengonfirmasi bahwa pekerjaan ini tidak membutuhkan penugasan tim PPC.')
                            ->required()
                    ];
                }
                return [];
            })
            ->action(function (LabJob $record, LabJobService $labJobService) use ($url) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::InProgress);
                    });

                    Notification::make()->title('Pekerjaan telah dimulai.')->success()->send();
                    return redirect()->to($url);
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal memulai pekerjaan')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    public static function completeSampling(): Action
    {
        return Action::make('Selesai Sampling')
            ->icon('heroicon-o-clipboard-document-check')
            ->color('info')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::InProgress->value)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                $labJobService->updateLabJobStatus($record, JobStatusEnum::SamplingCompleted);
                Notification::make()->title('Status pekerjaan diubah menjadi Sampling Selesai.')->success()->send();
            });
    }
    public static function completeAnalysis(): Action
    {
        return  Action::make('Selesai Analisis')
            ->icon('heroicon-o-magnifying-glass')
            ->color('info')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::SamplingCompleted->value)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                $labJobService->updateLabJobStatus($record, JobStatusEnum::AnalysisCompleted);
                Notification::make()->title('Status pekerjaan diubah menjadi Analisis Selesai.')->success()->send();
            });
    }
    public static function completeValidation(): Action
    {
        return  Action::make('Selesai Validasi')
            ->icon('heroicon-o-check-circle')
            ->color('info')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::AnalysisCompleted->value)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                $labJobService->updateLabJobStatus($record, JobStatusEnum::ValidationCompleted);
                Notification::make()->title('Status pekerjaan diubah menjadi Validasi Selesai.')->success()->send();
            });
    }
    public static function generateReport(): Action
    {
        return    Action::make('Buat Laporan')
            ->icon('heroicon-o-document-duplicate')
            ->color('success')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::ValidationCompleted->value)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                $labJobService->updateLabJobStatus($record, JobStatusEnum::ReportGenerated);
                Notification::make()->title('Status pekerjaan diubah menjadi Laporan Dibuat.')->success()->send();
            });
    }
    public static function approveReport(): Action
    {
        return    Action::make('Setujui Laporan')
            ->icon('heroicon-o-document-check')
            ->color('success')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::ReportGenerated->value)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                $labJobService->updateLabJobStatus($record, JobStatusEnum::ReportApproved);
                Notification::make()->title('Status pekerjaan diubah menjadi Laporan Disetujui.')->success()->send();
            });
    }
    public static function sendReport(): Action
    {
        return    Action::make('Kirim')
            ->icon('heroicon-o-truck')
            ->color('success')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::Invoiced->value)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                $labJobService->updateLabJobStatus($record, JobStatusEnum::Delivered);
                Notification::make()->title('Pekerjaan telah selesai dan dikirim.')->success()->send();
            });
    }
    public static function abortJob(): Action
    {
        return  Action::make('Batalkan Pekerjaan')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->visible(fn(LabJob $record) =>  $record->status == JobStatusEnum::InProgress->value)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                $labJobService->updateLabJobStatus($record, JobStatusEnum::Cancelled);
                Notification::make()->title('Pekerjaan telah dibatalkan.')->danger()->send();
            });
    }
}
