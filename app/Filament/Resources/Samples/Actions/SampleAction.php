<?php

namespace App\Filament\Resources\Samples\Actions;

use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJob;
use App\Models\Sample;
use App\Services\SampleService;
use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Colors\Color;

class SampleAction
{
    protected static string $labelDownloadUrl = 'sample_labels.download';
    protected static string $taskLetterPreviewUrl = 'task_letters.preview';


    public const PERMISSION_DOWNLOAD_LABEL = 'download-label-sample';
    public const PERMISSION_PREPARE = 'prepare-sample';


    protected static function isJobStatusAllowed(?LabJob $labJob): bool
    {
        return $labJob
            ? $labJob->status === JobStatusEnum::SamplingCompleted->value
            : true;
    }

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }

    public static function downloadLabel(?LabJob $labJob = null): Action
    {
        $allowedJobStatus = static::isJobStatusAllowed($labJob);
        $authorized = static::isAuthorized(static::PERMISSION_DOWNLOAD_LABEL);
        return Action::make('Label')
            ->icon(Heroicon::OutlinedPrinter)
            ->authorize(fn(Sample $record) => in_array($record->status, [SampleStatusEnum::Received->value, SampleStatusEnum::Prepared->value]) && $allowedJobStatus  && $authorized)
            ->url(fn(Sample $record): string => route(static::$labelDownloadUrl, $record))
            ->color('gray')
            ->openUrlInNewTab();
    }
    public static function prepare(?LabJob $labJob = null): Action
    {
        $allowedJobStatus = static::isJobStatusAllowed($labJob);
        $authorized = static::isAuthorized(static::PERMISSION_PREPARE);
        return  Action::make('Siapkan')
            ->icon(Heroicon::OutlinedClipboardDocumentCheck)
            ->color(fn(Sample $record) => SampleStatusEnum::color($record->status))
            ->authorize(fn(Sample $record) => $record->status === SampleStatusEnum::Received->value && $allowedJobStatus && $authorized)
            ->requiresConfirmation()
            ->action(function (Sample $record, SampleService $sampleService) {
                try {
                    DB::transaction(function () use ($record, $sampleService) {
                        $sampleService->updateSampleStatus($record, SampleStatusEnum::Prepared);
                    });
                    Notification::make()->title('Status sampel diubah menjadi disiapkan.')->success()->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal mengubah status disiapkan')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengubah status disiapkan', [
                        'sample_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
}
