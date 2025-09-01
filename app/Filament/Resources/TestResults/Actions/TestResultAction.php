<?php

namespace App\Filament\Resources\TestResults\Actions;

use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Services\TestResultService;

use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Log;

class TestResultAction
{

    public static function requestValidate($url = null): Action
    {
        $authorized = Auth::user()->can('request-validate-test-result');
        return  Action::make('Request Validasi')
            ->icon('heroicon-o-document-check')
            ->color('success')
            ->visible(fn(TestResult $record) => $record->status === TestResultStatusEnum::Raw->value && $authorized)
            ->requiresConfirmation()
            ->action(function (TestResult $record, TestResultService $testResultService) use ($url) {
                try {
                    DB::transaction(function () use ($testResultService, $record) {
                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::RequestValidate);
                    });
                    Notification::make()->title('Hasil uji sudah dikirim untuk di validasi')->success()->send();
                    if ($url) {
                        return redirect()->to($url);
                    }
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
    public static function validate($url = null): Action
    {
        $authorized = Auth::user()->can('validating-test-result');
        return  Action::make('Validasi Hasil Uji')
            ->icon('heroicon-o-document-check')
            ->color('success')
            ->visible(fn(TestResult $record) => $record->status === TestResultStatusEnum::RequestValidate->value && $authorized)
            ->requiresConfirmation()
            ->action(function (TestResult $record, TestResultService $testResultService) use ($url) {
                try {
                    DB::transaction(function () use ($testResultService, $record) {
                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::Validated);
                    });
                    Notification::make()->title('Hasil uji sudah tervalidasi')->success()->send();
                    if ($url) {
                        return redirect()->to($url);
                    }
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
