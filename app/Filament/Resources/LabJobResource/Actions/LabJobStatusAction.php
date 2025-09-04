<?php

namespace App\Filament\Resources\LabJobResource\Actions;

use App\Models\Enums\JobStatusEnum;
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
    protected static string $taskLetterDownloadUrl = 'lab_jobs.download_task_letter';
    protected static string $taskLetterPreviewUrl = 'lab_jobs.preview_task_letter';
    protected static array $permissions = [
        'preview-lab-job-task-letter', //0
        'download-lab-job-task-letter', //1
        'print-lab-job-task-letter', //2
        'start-lab-job', //3
        'complete-lab-job-sampling', //4
        'complete-lab-job-analysis', //5
        'complete-lab-job-validation', //6
        'generate-lab-job-report', //7
        'approve-lab-job-report', //8
        'send-lab-job-report', //9
        'abort-lab-job-report', //10

    ];
    public static function previewTaskLetter(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[0]);
        return Action::make('Preview Surat Tugas')
            ->label(fn($record) => $record->labJobPersonels->isNotEmpty() ? 'Preview Surat Tugas' : 'Tidak Ada Surat Tugas')
            ->color(Color::Blue) // Menggunakan warna biru Filament
            ->icon('heroicon-o-eye')
            ->slideOver()
            ->disabled(fn($record) => !$record->labJobPersonels->isNotEmpty())
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::InProgress->value && $authorized)
            ->modalHeading('Pratinjau Surat Tugas')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup Pratinjau')
            ->modalWidth('6xl')
            ->modalContent(function (LabJob $record) {
                $safeJobNumber = Str::of($record->job_number)->replace('/', '-');
                $pdfUrl = route(static::$taskLetterDownloadUrl, $record);
                $downloadUrl = route(static::$taskLetterPreviewUrl, $record);

                return view('pdfs.preview', [
                    'pdfUrl' => $pdfUrl,
                    'safeFileName' => $safeJobNumber,
                    'downloadUrl' => $downloadUrl
                ]);
            })
            ->modalFooterActions([
                static::downloadTaskLetter(),
            ])
            ->modalFooterActionsAlignment('right');
    }

    public static function downloadTaskLetter(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[1]);
        return  Action::make('Download')
            ->visible(fn() => $authorized)
            ->url(fn(LabJob $record): string => route(static::$taskLetterDownloadUrl, $record))
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            ->openUrlInNewTab();
    }
    public static function printTaskLetter(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[2]);
        return Action::make('Cetak Surat Tugas')
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            // Hanya tampil jika pekerjaan sudah dimulai
            ->visible(fn(LabJob $record) => $record->job_status === JobStatusEnum::InProgress->value && $authorized)
            ->url(fn(LabJob $record): string => route(static::$taskLetterDownloadUrl, $record))
            ->openUrlInNewTab();
    }
    public static function startJob($url = null): Action
    {
        $authorized = Auth::user()->can(static::$permissions[3]);
        return Action::make('Mulai Pekerjaan')
            ->icon('heroicon-o-play')
            ->color('success')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::PendingStart->value &&  $authorized)
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
                    if ($url) {
                        return redirect()->to($url);
                    }
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
        $authorized = Auth::user()->can(static::$permissions[4]);
        return Action::make('Selesai Sampling')
            ->icon('heroicon-o-clipboard-document-check')
            ->color('info')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::InProgress->value && $authorized && count($record->samples) > 0)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::SamplingCompleted);
                    });

                    Notification::make()->title('Status pekerjaan diubah menjadi Sampling Selesai.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal menyelesaikan sampling')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
    public static function completeAnalysis(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[5]);
        return  Action::make('Selesai Analisis')
            ->icon('heroicon-o-magnifying-glass')
            ->color('info')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::SamplingCompleted->value && $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::AnalysisCompleted);
                    });
                    Notification::make()->title('Status pekerjaan diubah menjadi Analisis Selesai.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal menyelesaikan sampling')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal menyelesaikan analisis', [
                        'lab_job_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
    public static function completeValidation(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[6]);
        return  Action::make('Selesai Validasi')
            ->icon('heroicon-o-check-circle')
            ->color('info')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::AnalysisCompleted->value && $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::ValidationCompleted);
                    });
                    Notification::make()->title('Status pekerjaan diubah menjadi Validasi Selesai.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal menyelesaikan sampling')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal menyelesaikan sampling', [
                        'lab_job_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
    public static function generateReport(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[7]);
        return    Action::make('Buat Laporan')
            ->icon('heroicon-o-document-duplicate')
            ->color('success')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::ValidationCompleted->value && $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::ReportGenerated);
                    });
                    Notification::make()->title('Status pekerjaan diubah menjadi Laporan Dibuat.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal mengubah status laporan dibuat')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengubah status laporan dibuat', [
                        'lab_job_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
    public static function approveReport(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[8]);
        return    Action::make('Setujui Laporan')
            ->icon('heroicon-o-document-check')
            ->color('success')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::ReportGenerated->value && $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::ReportApproved);
                    });
                    Notification::make()->title('Status pekerjaan diubah menjadi Laporan Disetujui.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal mengubah status laporan disetujui')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengubah status laporan disetujui', [
                        'lab_job_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
    public static function sendReport(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[9]);
        return    Action::make('Kirim')
            ->icon('heroicon-o-truck')
            ->color('success')
            ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::Invoiced->value && $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::Delivered);
                    });
                    Notification::make()->title('Pekerjaan telah selesai dan dikirim.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal mengubah status Pekerjaan telah selesai dan dikirim')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengubah status Pekerjaan telah selesai dan dikirim', [
                        'lab_job_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
    public static function abortJob(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[10]);
        return  Action::make('Batalkan Pekerjaan')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->visible(fn(LabJob $record) =>  $record->status == JobStatusEnum::InProgress->value &&  $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::Cancelled);
                    });
                    Notification::make()->title('Pekerjaan telah dibatalkan.')->danger()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal mengubah status Pekerjaan telah dibatalkan')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengubah status Pekerjaan telah dibatalkan', [
                        'lab_job_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
}
