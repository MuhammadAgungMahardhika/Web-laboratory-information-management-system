<?php

namespace App\Filament\Resources\LabJobResource\Actions;

use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJob;
use App\Services\LabJobService;

use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class LabJobStatusAction
{
    protected static string $previewFinalReport = 'final_reports.preview';
    protected static string $downloadFinalReport = 'final_reports.download';

    protected static string $previewAnalystTestResultUrl = 'analyst_reports.preview';
    protected static string $downloadAnalystTestResultUrl = 'analyst_reports.download';

    protected static string $taskLetterPreviewUrl = 'task_letters.preview';
    protected static string $taskLetterDownloadUrl = 'task_letters.download';

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

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }
    public static function previewTaskLetter(): Action
    {

        $authorized = static::isAuthorized(static::PERMISSION_PREVIEW_LAB_JOB_TASK_LETTER);
        return Action::make('Surat Tugas')
            ->label(fn($record) => 'Surat Tugas')
            ->color(Color::Gray) // Menggunakan warna biru Filament
            ->icon(Heroicon::DocumentDuplicate)
            ->slideOver()
            ->disabled(fn($record) => $record->labJobPersonels->isEmpty())
            ->authorize(fn(LabJob $record) => $record->status !== JobStatusEnum::Draft->value && $authorized)
            ->modalHeading('Pratinjau Surat Tugas')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup Pratinjau')
            ->modalWidth('6xl')
            ->modalContent(function (LabJob $record) {
                $safeJobNumber = Str::of($record->code)->replace('/', '-');
                $pdfUrl = route(static::$taskLetterPreviewUrl, $record);
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
            ->authorize(fn(LabJob $record) => $record->job_status !== JobStatusEnum::Draft->value && $authorized)
            ->url(fn(LabJob $record): string => route(static::$taskLetterDownloadUrl, $record))
            ->openUrlInNewTab();
    }
    public static function startJob($url = null): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_START_LAB_JOB);
        return Action::make('Mulai Job')
            ->icon('heroicon-o-play')
            ->color('success')
            ->authorize(function (LabJob $record, LabJobService $labJobService) use ($authorized) {
                return $record->status === JobStatusEnum::Draft->value
                    && $authorized
                    && $labJobService->canStartJob($record);
            })
            ->requiresConfirmation()
            ->modalHeading('Konfirmasi Memulai Job')
            ->schema(function (LabJob $record) {
                $fields = [
                    // --- FIELDS BARU UNTUK START & END DATE ---
                    DatePicker::make('start_date')
                        ->label('Tanggal Mulai Aktual')
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            // Jika start_date diubah secara manual, update count_days
                            if ($state && $get('end_date')) {
                                $startDate = \Carbon\Carbon::parse($state);
                                $endDate = \Carbon\Carbon::parse($get('end_date'));
                                $countDays = $startDate->diffInDays($endDate);
                                $set('count_days', $countDays . " hari");
                            }
                        })
                        ->minDate(now()->toDateString())
                        ->default(now()->toDateString())
                        ->required(),
                    DatePicker::make('end_date')
                        ->label('Tenggat Waktu Selesai')
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            // Jika end_date diubah secara manual, update count_days
                            if ($state && $get('start_date')) {
                                $startDate = \Carbon\Carbon::parse($get('start_date'));
                                $endDate = \Carbon\Carbon::parse($state);
                                $countDays = $startDate->diffInDays($endDate);
                                $set('count_days', $countDays . " hari");
                            }
                        })
                        ->default(now()->addDays(30)->toDateString())
                        ->hint('Default 30 hari dari tanggal mulai')
                        ->after('start_date')
                        ->live()
                        ->minDate(fn(callable $get) => $get('start_date') ?? \Carbon\Carbon::parse($get('start_date')))
                        ->required(),
                    TextEntry::make('count_days')
                        ->label('Total Hari Pengerjaan')
                        ->disabled()
                        ->default(fn(callable $get) => $get('start_date') && $get('end_date') ? \Carbon\Carbon::parse($get('start_date'))->diffInDays(\Carbon\Carbon::parse($get('end_date'))) . " hari" : '')
                        ->live(),
                ];

                // Tambahkan checkbox konfirmasi jika tidak ada personel
                if ($record->labJobPersonels->isEmpty()) {
                    $fields[] = Checkbox::make('skip_assignment_confirmation')
                        ->label('Saya mengonfirmasi bahwa pekerjaan ini tidak membutuhkan penugasan tim PPC.')
                        ->required();
                }
                return $fields;
            })
            // --- ACTION YANG SUDAH DIPERBARUI UNTUK MENERIMA $data ---
            ->action(function (LabJob $record, array $data, LabJobService $labJobService) use ($url) {
                try {
                    // Periksa apakah ada personel yang ditugaskan atau dikonfirmasi untuk dilewati
                    if ($record->labJobPersonels->isEmpty() && !($data['skip_assignment_confirmation'] ?? false)) {
                        // Ini seharusnya tidak terjadi karena sudah di-guard di modalDescription/schema
                        Notification::make()->title('Gagal: Konfirmasi penugasan diperlukan.')->danger()->send();
                        return;
                    }
                    if (! $labJobService->canStartJob($record)) {
                        throw new Exception(
                            'Lab Job belum memiliki produk uji. Tambahkan minimal satu produk uji sebelum memulai pekerjaan.'
                        );
                    }

                    DB::transaction(function () use ($record, $labJobService, $data) {
                        // Update status dan tanggal menggunakan service
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::Sampling, $data);
                    });

                    Notification::make()->title('Lab Job telah dimulai.')->success()->send();
                    if ($url) {
                        return redirect()->to($url);
                    }
                } catch (\Exception $e) {
                    // ... (Logika error handling) ...
                    Notification::make()
                        ->title('Gagal memulai pekerjaan')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
    public static function completeSampling(string $url = null): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_COMPLETE_LAB_JOB_SAMPLING);
        return Action::make('Selesai Sampling')
            ->icon('heroicon-o-clipboard-document-check')
            ->color('info')
            ->authorize(function (LabJob $record, LabJobService $labJobService) use ($authorized) {
                return $record->status === JobStatusEnum::Sampling->value
                    && $authorized
                    && $labJobService->canCompleteSampling($record);
            })
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) use ($url) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {

                        if (! $labJobService->canCompleteSampling($record)) {
                            throw new \Exception(
                                'Masih terdapat produk uji yang belum memiliki sampel atau status sampel tidak valid.'
                            );
                        }

                        $labJobService->updateLabJobStatus(
                            $record,
                            JobStatusEnum::SamplingCompleted
                        );
                    });

                    Notification::make()
                        ->title('Status pekerjaan diubah menjadi Sampling Selesai.')
                        ->success()
                        ->send();

                    if ($url) {
                        return redirect()->to($url);
                    }
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal menyelesaikan sampling')
                        ->body($e->getMessage())
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
    public static function completeJob(): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_COMPLETE_LAB_JOB_VALIDATION);
        return  Action::make('Selesai Job')
            ->icon('heroicon-o-check-circle')
            ->color('info')
            ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::AnalysisCompleted->value && $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::JobCompleted);
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
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::Paid);
                    });
                    Notification::make()->title('Lab Job telah selesai dan dikirim.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal mengubah status Lab Job telah selesai dan dikirim')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengubah status Lab Job telah selesai dan dikirim', [
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
        return  Action::make('Batalkan Lab Job')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->authorize(fn(LabJob $record) =>  $record->status == JobStatusEnum::Sampling->value &&  $authorized)
            ->requiresConfirmation()
            ->action(function (LabJob $record, LabJobService $labJobService) {
                try {
                    DB::transaction(function () use ($record, $labJobService) {
                        $labJobService->updateLabJobStatus($record, JobStatusEnum::Cancelled);
                    });
                    Notification::make()->title('Lab Job telah dibatalkan.')->danger()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal mengubah status Lab Job telah dibatalkan')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengubah status Lab Job telah dibatalkan', [
                        'lab_job_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
    public static function previewFinalReport(): Action
    {
        return  Action::make('Final Report')
            ->icon(Heroicon::DocumentChartBar)
            ->slideOver()
            ->modalHeading('Pratinjau Laporan Pengujian') // Judul modal
            ->modalSubmitAction(false) // Sembunyikan tombol submit (kita hanya preview)
            ->modalCancelActionLabel('Tutup Pratinjau') // Ubah label tombol cancel
            ->modalWidth('6xl') // Atur lebar modal (misal: '7xl' atau 'full')
            ->modalContent(function (LabJob $record) {
                // Ini adalah cara untuk me-render Blade view di dalam modal
                // Gunakan blade view khusus untuk iframe atau langsung iframe di sini
                $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->code);
                $pdfUrl = route(static::$previewFinalReport, $record);
                $downloadUrl = route(static::$downloadFinalReport, $record);

                return view('pdfs.preview', [
                    'pdfUrl' => $pdfUrl,
                    'safeFileName' => $safeFileName, // Opsional, jika perlu di view modal
                    'downloadUrl' => $downloadUrl, // Opsional, jika perlu di view modal
                ]);
            })->modalFooterActions([
                static::downloadFinalReport(),
                // static::sendReport(),
            ])->modalFooterActionsAlignment('right');
    }
    public static function downloadFinalReport(): Action
    {
        return  Action::make('Download Final Report')
            ->url(fn(LabJob $record): string => route(static::$downloadFinalReport, $record))
            ->icon(Heroicon::OutlinedPrinter)
            ->outlined()
            // ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::ReportApproved->value)
            ->openUrlInNewTab();
    }

    public static function previewAnalystTestReport(): Action
    {
        return  Action::make('Lembar Pengujian Analis')
            ->icon(Heroicon::DocumentText)
            ->slideOver()
            ->modalHeading('Pratinjau LPA') // Judul modal
            ->modalSubmitAction(false) // Sembunyikan tombol submit (kita hanya preview)
            ->modalCancelActionLabel('Tutup Pratinjau') // Ubah label tombol cancel
            ->modalWidth('6xl') // Atur lebar modal (misal: '7xl' atau 'full')
            ->modalContent(function (LabJob $record) {
                // Ini adalah cara untuk me-render Blade view di dalam modal
                // Gunakan blade view khusus untuk iframe atau langsung iframe di sini
                $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $record->code);
                $pdfUrl = route(static::$previewAnalystTestResultUrl, $record);
                $downloadUrl = route(static::$downloadAnalystTestResultUrl, $record);


                return view('pdfs.preview', [
                    'pdfUrl' => $pdfUrl,
                    'safeFileName' => $safeFileName, // Opsional, jika perlu di view modal
                    'downloadUrl' => $downloadUrl, // Opsional, jika perlu di view modal
                ]);
            })->modalFooterActions([
                static::downloadAnalystTestReport(),
                // static::sendAnalystTestReport(),
            ])->modalFooterActionsAlignment('right');
    }

    public static function resetToQuotationSnapshot(LabJob $labJob): Action
    {

        return Action::make('resetToQuotationSnapshot')
            ->label('Kembalikan Rincian Lab Job')
            ->icon(Heroicon::ArrowUturnLeft)
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('Kembalikan Rincian Lab Job?')
            ->modalDescription('Ini akan menghapus semua rincian pekerjaan saat ini dan menggantinya dengan rincian dari penawaran awal.')
            ->modalSubmitActionLabel('Ya, Kembalikan')
            ->action(function (LabJobService $labJobService) use ($labJob) {
                try {

                    DB::transaction(function () use ($labJobService, $labJob) {
                        $labJobService->resetToQuotationSnapshot($labJob);
                    });

                    Notification::make()
                        ->title('Rincian pekerjaan berhasil dikembalikan.')
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    Log::error('Gagal mengembalikan rincian pekerjaan: ' . $e->getMessage());

                    Notification::make()
                        ->title('Gagal mengembalikan rincian pekerjaan.')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->after(function (RelationManager $livewire) {
                $livewire->dispatch('refresh');
            })
            ->visible(function (RelationManager $livewire) use ($labJob) {
                return ! $livewire->isReadOnly()
                    && $labJob->status === JobStatusEnum::Draft->value;
            });
    }
    public static function downloadAnalystTestReport(): Action
    {
        return  Action::make('Download Lpa')
            ->url(fn(LabJob $record): string => route(static::$downloadAnalystTestResultUrl, $record))
            ->icon(Heroicon::OutlinedPrinter)
            ->color(Color::Gray)
            ->outlined()
            // ->authorize(fn(LabJob $record) => $record->status === JobStatusEnum::ReportApproved->value)
            ->openUrlInNewTab();
    }
}
