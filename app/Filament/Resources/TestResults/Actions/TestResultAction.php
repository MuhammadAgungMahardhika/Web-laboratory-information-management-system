<?php

namespace App\Filament\Resources\TestResults\Actions;

use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Services\TestResultService;
use Auth;
use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Log;

class TestResultAction
{

    public static function sendClarification($url): Action
    {
        return  Action::make('Request Validasi')
            ->icon('heroicon-o-document-check')
            ->color('success')
            ->visible(fn(TestResult $record) => $record->status === TestResultStatusEnum::Raw->value)
            ->requiresConfirmation()
            ->action(function (TestResult $record, TestResultService $testResultService) use ($url) {
                try {
                    DB::transaction(function () use ($testResultService, $record) {
                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::ClarificationNeeded);
                    });
                    Notification::make()->title('Hasil uji sudah dikirim untuk di validasi')->success()->send();
                    return redirect()->to($url);
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal Request validasi hasil uji')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal Request validasi hasil uji', [
                        'quotation_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
    public static function validate($url): Action
    {
        return  Action::make('Validasi Hasil Uji')
            ->icon('heroicon-o-document-check')
            ->color('success')
            ->visible(fn(TestResult $record) => $record->status === TestResultStatusEnum::ClarificationNeeded->value)
            ->requiresConfirmation()
            ->action(function (TestResult $record, TestResultService $testResultService) use ($url) {
                try {
                    DB::transaction(function () use ($testResultService, $record) {
                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::Validated);
                    });
                    Notification::make()->title('Hasil uji sudah tervalidasi')->success()->send();
                    return redirect()->to($url);
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal validasi hasil uji')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();
                    Log::error('Gagal mengirimkan penawaran', [
                        'quotation_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }
}
