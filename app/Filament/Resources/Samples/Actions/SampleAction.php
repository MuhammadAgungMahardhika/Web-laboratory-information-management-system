<?php

namespace App\Filament\Resources\LabJobResource\Actions;

use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJob;
use App\Models\Sample;
use App\Services\LabJobService;
use App\Services\SampleService;
use App\Services\TestResultService;
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

class SampleAction
{
    protected static string $labelDownloadUrl = 'samples.download_label';
    protected static string $taskLetterPreviewUrl = 'lab_jobs.preview_task_letter';
    protected static array $permissions = [
        'download-label-sample',
        'prepare-sample', //1
    ];

    public static function downloadLabel(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[0]);
        return Action::make('Label')
            ->icon(Heroicon::OutlinedPrinter)
            ->visible(fn(Sample $record) => in_array($record->status, [SampleStatusEnum::Received->value, SampleStatusEnum::Prepared->value]) && $record->labJobItem->labJob->status === JobStatusEnum::SamplingCompleted->value && $authorized)
            ->url(fn(Sample $record): string => route(static::$labelDownloadUrl, $record))
            ->color('gray')
            ->openUrlInNewTab();
    }
    public static function prepare(): Action
    {
        $authorized = Auth::user()->can(static::$permissions[0]);
        return  Action::make('Siapkan')
            ->icon(Heroicon::OutlinedClipboardDocumentCheck)
            ->color(fn(Sample $record) => SampleStatusEnum::color($record->status))
            ->visible(fn(Sample $record) => $record->status === SampleStatusEnum::Received->value && $record->labJobItem->labJob->status === JobStatusEnum::SamplingCompleted->value && $authorized)
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
