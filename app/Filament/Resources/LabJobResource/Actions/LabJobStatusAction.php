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
use Filament\Support\Icons\Heroicon;

class LabJobStatusAction
{
    protected static string $reportPreviewUrl = 'reports.preview_report';
    protected static string $reportDownloadUrl = 'reports.download_report';

    protected static string $taskLetterDownloadUrl = 'lab_jobs.download_task_letter';
    protected static string $taskLetterPreviewUrl = 'lab_jobs.preview_task_letter';

    public const PERMISSION_PREVIEW_LAB_JOB_TASK_LETTER =    'preview-lab-job-task-letter';
    public const PERMISSION_DOWNLOAD_LAB_JOB_TASK_LETTER =   'download-lab-job-task-letter';
    public const PERMISSION_PRINT_LAB_JOB_TASK_LETTER =   'print-lab-job-task-letter';
    public const PERMISSION_START_LAB_JOB =  'start-lab-job';
    public const PERMISSION_COMPLETE_LAB_JOB_SAMPLING =  'complete-lab-job-sampling';
    public const PERMISSION_COMPLETE_LAB_JOB_ANALYST =     'complete-lab-job-analysis';
    public const PERMISSION_COMPLETE_LAB_JOB_VALIDATION =    'complete-lab-job-validation';
    public const PERMISSION_GENERATE_LAB_JOB_REPORT =  'generate-lab-job-report';
    public const PERMISSION_APPROVE_LAB_JOB_REPORT  = 'approve-lab-job-report';
    public const PERMISSION_SEND_LAB_JOB_REPORT  =  'send-lab-job-report';
    public const PERMISSION_ABORT_LAB_JOB_REPORT  =  'abort-lab-job-report';
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

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }
    public static function previewTaskLetter(): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_PREVIEW_LAB_JOB_TASK_LETTER);
        return Action::make('Preview Surat Tugas')
            ->label(fn($record) => $record->labJobPersonels->isNotEmpty() ? 'Preview Surat Tugas' : 'Tidak Ada Surat Tugas')
            ->color(Color::Blue) // Menggunakan warna biru Filament
            ->icon('heroicon-o-eye')
            ->slideOver()
            ->disabled(fn($record) => !$record->labJobPersonels->isNotEmpty())
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::InProgress->value && $authorized)
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
        $authorized = static::isAuthorized(static::PERMISSION_DOWNLOAD_LAB_JOB_TASK_LETTER);
        return  Action::make('Download')
            ->authorize(fn() => $authorized)
            ->url(fn(LabJob $record): string => route(static::$taskLetterDownloadUrl, $record))
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            ->openUrlInNewTab();
    }
    public static function printTaskLetter(): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_PRINT_LAB_JOB_TASK_LETTER);
        return Action::make('Cetak Surat Tugas')
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            // Hanya tampil jika pekerjaan sudah dimulai
            ->authorize(fn(LabJob $record) => $record->job_status === JobStatusEnum::InProgress->value && $authorized)
            ->url(fn(LabJob $record): string => route(static::$taskLetterDownloadUrl, $record))
            ->openUrlInNewTab();
    }
    public static function startJob($url = null): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_START_LAB_JOB);
        return Action::make('Mulai Pekerjaan')
            ->icon('heroicon-o-play')
            ->color('success')
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::PendingStart->value &&  $authorized)
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
        $authorized = static::isAuthorized(static::PERMISSION_COMPLETE_LAB_JOB_SAMPLING);
        return Action::make('Selesai Sampling')
            ->icon('heroicon-o-clipboard-document-check')
            ->color('info')
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::InProgress->value && $authorized && count($record->samples) > 0)
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
        $authorized = static::isAuthorized(static::PERMISSION_COMPLETE_LAB_JOB_ANALYST);
        return  Action::make('Selesai Analisis')
            ->icon('heroicon-o-magnifying-glass')
            ->color('info')
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::SamplingCompleted->value && $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::AnalysisCompleted);
                    });
                    Notification::make()->title('Status pekerjaan diubah menjadi selesai analisis.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal menandai lab job sebagai selesai analisis')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal menandai lab job sebagai selesai analisis', [
                        'lab_job_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
    public static function completeValidation(): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_COMPLETE_LAB_JOB_VALIDATION);
        return  Action::make('Selesai Validasi')
            ->icon('heroicon-o-check-circle')
            ->color('info')
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::AnalysisCompleted->value && $authorized)
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
        $authorized = static::isAuthorized(static::PERMISSION_GENERATE_LAB_JOB_REPORT);
        return    Action::make('Buat Laporan')
            ->icon('heroicon-o-document-duplicate')
            ->color('success')
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::ValidationCompleted->value && $authorized)
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
        $authorized = static::isAuthorized(static::PERMISSION_APPROVE_LAB_JOB_REPORT);
        return    Action::make('Setujui Laporan')
            ->icon('heroicon-o-document-check')
            ->color('success')
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::ReportGenerated->value && $authorized)
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
        $authorized = static::isAuthorized(static::PERMISSION_SEND_LAB_JOB_REPORT);
        return    Action::make('Kirim')
            ->icon('heroicon-o-truck')
            ->color('success')
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::Invoiced->value && $authorized)
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
        $authorized = static::isAuthorized(static::PERMISSION_ABORT_LAB_JOB_REPORT);
        return  Action::make('Batalkan Pekerjaan')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->authorize(fn(LabJob $record) =>  $record->status == JobStatusEnum::InProgress->value &&  $authorized)
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
    public static function previewReport(): Action
    {
        return  Action::make('Preview Laporan Hasil')
            ->icon(Heroicon::OutlinedEye)
            ->color('info')
            ->slideOver()
            ->modalHeading('Pratinjau Laporan Hasil Uji') // Judul modal
            ->modalSubmitAction(false) // Sembunyikan tombol submit (kita hanya preview)
            ->modalCancelActionLabel('Tutup Pratinjau') // Ubah label tombol cancel
            ->modalWidth('6xl') // Atur lebar modal (misal: '7xl' atau 'full')
            ->modalContent(function (LabJob $record) {
                // Ini adalah cara untuk me-render Blade view di dalam modal
                // Gunakan blade view khusus untuk iframe atau langsung iframe di sini
                $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->job_number);
                $pdfUrl = route(static::$reportPreviewUrl, $record);
                $downloadUrl = route(static::$reportDownloadUrl, $record);

                return view('pdfs.preview', [
                    'pdfUrl' => $pdfUrl,
                    'safeFileName' => $safeFileName, // Opsional, jika perlu di view modal
                    'downloadUrl' => $downloadUrl, // Opsional, jika perlu di view modal
                ]);
            })->modalFooterActions([
                static::downloadReport(),
                // static::sendReport(),
            ])->modalFooterActionsAlignment('right');
    }
    public static function downloadReport(): Action
    {
        return  Action::make('Cetak Laporan Hasil ')
            ->url(fn(LabJob $record): string => route(static::$reportDownloadUrl, $record))
            ->icon(Heroicon::OutlinedPrinter)
            ->color(Color::Gray)
            ->outlined()
            // ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::ReportApproved->value)
            ->openUrlInNewTab();
    }
}
