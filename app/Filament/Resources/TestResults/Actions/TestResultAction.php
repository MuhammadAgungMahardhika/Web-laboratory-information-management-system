<?php

namespace App\Filament\Resources\TestResults\Actions;

use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Services\TestResultService;

use Exception;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class TestResultAction
{
    public const PERMISSION_REQUEST_VALIDATE_TEST_RESULT =  'request-validate-test-result';
    public const PERMISSION_VALIDATE_TEST_RESULT =  'validate-test-result';
    public const PERMISSION_REVISION_NEEDED_TEST_RESULT =  'revision-needed-test-result';
    public const PERMISSION_REJECT_TEST_RESULT =  'reject-test-result';

    public static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }

    public static function requestValidate($url = null): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_REQUEST_VALIDATE_TEST_RESULT);
        return  Action::make('Request Validasi')
            ->icon(Heroicon::ArrowUpTray)
            ->color('warning')
            ->authorize(fn(TestResult $record) => in_array($record->status, [TestResultStatusEnum::Raw->value, TestResultStatusEnum::RevisionNeeded->value]) && $record->tested_value && $authorized)
            ->requiresConfirmation()
            ->action(function (TestResult $record, TestResultService $testResultService, $livewire) use ($url) {
                try {
                    DB::transaction(function () use ($testResultService, $record) {
                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::RequestValidate);
                    });
                    Notification::make()->title('Hasil uji sudah dikirim untuk di validasi')->success()->send();
                    if ($url) {
                        return redirect()->to($url);
                    } else {
                        $livewire->mountedTableActionData = [];
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
        $authorized = static::isAuthorized(static::PERMISSION_REQUEST_VALIDATE_TEST_RESULT);
        return  Action::make('Validasi')
            ->icon(Heroicon::Check)
            ->color('success')
            ->authorize(fn(TestResult $record) => $record->status === TestResultStatusEnum::RequestValidate->value && $authorized)
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
    public static function revisionNeeded($url = null): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_REVISION_NEEDED_TEST_RESULT);

        return Action::make('Perlu Revisi')
            ->icon(Heroicon::PencilSquare) // lebih cocok untuk revisi
            ->color('warning')
            ->authorize(
                fn(TestResult $record) =>
                $record->status === TestResultStatusEnum::RequestValidate->value && $authorized
            )
            ->requiresConfirmation()
            ->action(function (TestResult $record, TestResultService $testResultService) use ($url) {
                try {
                    DB::transaction(function () use ($testResultService, $record) {
                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::RevisionNeeded);
                    });

                    Notification::make()
                        ->title('Hasil uji ditandai perlu revisi')
                        ->success()
                        ->send();

                    if ($url) {
                        return redirect()->to($url);
                    }
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal menandai hasil uji untuk revisi')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();

                    Log::error('Gagal memperbarui status hasil uji ke revisi', [
                        'test_result_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }

    public static function reject($url = null): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_REJECT_TEST_RESULT);

        return Action::make('Tolak')
            ->icon(Heroicon::XCircle) // ikon penolakan
            ->color('danger')
            ->visible(
                fn(TestResult $record) =>
                $record->status === TestResultStatusEnum::RequestValidate->value && $authorized
            )
            ->requiresConfirmation()
            ->action(function (TestResult $record, TestResultService $testResultService) use ($url) {
                try {
                    DB::transaction(function () use ($testResultService, $record) {
                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::Rejected);
                    });

                    Notification::make()
                        ->title('Hasil uji ditolak')
                        ->success()
                        ->send();

                    if ($url) {
                        return redirect()->to($url);
                    }
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal menolak hasil uji')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();

                    Log::error('Gagal memperbarui status hasil uji ke ditolak', [
                        'test_result_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }

    public static function bulkRequestValidate(): BulkAction
    {
        return  BulkAction::make('requestValidate')
            ->label('Request Validasi')
            ->icon(Heroicon::ArrowUpTray)
            ->requiresConfirmation()
            ->authorize(fn() => TestResultAction::isAuthorized(TestResultAction::PERMISSION_REQUEST_VALIDATE_TEST_RESULT))
            ->color('warning')
            ->action(function (Collection $records) {
                $testResultService = new TestResultService();
                $successCount = 0;
                $failedCount = 0;
                foreach ($records as $record) {
                    try {
                        DB::transaction(function () use ($testResultService, $record) {
                            $testResultService->updateTestResultStatus($record, TestResultStatusEnum::RequestValidate);
                        });
                        $successCount++;
                    } catch (\Exception $e) {
                        $failedCount++;
                    }
                }
                if ($successCount > 0) {
                    Notification::make()
                        ->title("Request Validasi Berhasil")
                        ->body("{$successCount} hasil uji berhasil untuk request validasi.")
                        ->success()
                        ->send();
                }
                if ($failedCount > 0) {
                    Notification::make()
                        ->title("Request Validasi Gagal")
                        ->body("{$failedCount} hasil uji gagal untuk request validasi.")
                        ->danger()
                        ->send();
                }
            })
            ->deselectRecordsAfterCompletion();
    }
    public static function bulkValidate(): BulkAction
    {
        return   BulkAction::make('validate')
            ->label('Validasi')
            ->icon(Heroicon::Check)
            ->authorize(fn() => TestResultAction::isAuthorized(TestResultAction::PERMISSION_VALIDATE_TEST_RESULT))
            ->requiresConfirmation()
            ->color('success')
            ->action(function (Collection $records) {
                $testResultService = new TestResultService();
                $successCount = 0;
                $failedCount = 0;
                foreach ($records as $record) {
                    try {
                        DB::transaction(function () use ($testResultService, $record) {
                            $testResultService->updateTestResultStatus($record, TestResultStatusEnum::Validated);
                        });
                        $successCount++;
                    } catch (\Exception $e) {
                        $failedCount++;
                    }
                }
                if ($successCount > 0) {
                    Notification::make()
                        ->title("Validasi Berhasil")
                        ->body("{$successCount} hasil uji berhasil divalidasi.")
                        ->success()
                        ->send();
                }
                if ($failedCount > 0) {
                    Notification::make()
                        ->title("Validasi Gagal")
                        ->body("{$failedCount} hasil uji gagal divalidasi.")
                        ->danger()
                        ->send();
                }
            })
            ->deselectRecordsAfterCompletion();
    }
    public static function bulkRevisionNeeded(): BulkAction
    {
        return  BulkAction::make('revision_needed')
            ->label('Perlu Revisi')
            ->icon(Heroicon::PencilSquare)
            ->authorize(fn() => TestResultAction::isAuthorized(TestResultAction::PERMISSION_REVISION_NEEDED_TEST_RESULT))
            ->requiresConfirmation()
            ->color('warning')
            ->action(function (Collection $records) {
                $testResultService = new TestResultService();
                $successCount = 0;
                $failedCount = 0;
                foreach ($records as $record) {
                    try {
                        DB::transaction(function () use ($testResultService, $record) {
                            $testResultService->updateTestResultStatus($record, TestResultStatusEnum::RevisionNeeded);
                        });
                        $successCount++;
                    } catch (\Exception $e) {
                        $failedCount++;
                    }
                }
                if ($successCount > 0) {
                    Notification::make()
                        ->title("Berhasil menandai status menjadi revisi")
                        ->body("{$successCount} hasil uji ditandai sebagai revisi.")
                        ->success()
                        ->send();
                }
                if ($failedCount > 0) {
                    Notification::make()
                        ->title("Gagal menandai status menjadi revisi ")
                        ->body("{$failedCount} hasil uji gagal ditandai sebagai revisi.")
                        ->danger()
                        ->send();
                }
            })
            ->deselectRecordsAfterCompletion();
    }
    public static function bulkReject(): BulkAction
    {
        return     BulkAction::make('reject')
            ->label('Tolak Hasil Uji')
            ->icon(Heroicon::XCircle)
            ->authorize(fn() => TestResultAction::isAuthorized(TestResultAction::PERMISSION_REJECT_TEST_RESULT))
            ->requiresConfirmation()
            ->color('danger')
            ->action(function (Collection $records) {
                $testResultService = new TestResultService();
                $successCount = 0;
                $failedCount = 0;
                foreach ($records as $record) {
                    try {
                        DB::transaction(function () use ($testResultService, $record) {
                            $testResultService->updateTestResultStatus($record, TestResultStatusEnum::Rejected);
                        });
                        $successCount++;
                    } catch (\Exception $e) {
                        $failedCount++;
                    }
                }
                if ($successCount > 0) {
                    Notification::make()
                        ->title("Berhasil menandai status menjadi ditolak")
                        ->body("{$successCount} hasil uji ditandai sebagai ditolak.")
                        ->success()
                        ->send();
                }
                if ($failedCount > 0) {
                    Notification::make()
                        ->title("Gagal menandai status menjadi ditolak ")
                        ->body("{$failedCount} hasil uji gagal ditandai sebagai ditolak.")
                        ->danger()
                        ->send();
                }
            })
            ->deselectRecordsAfterCompletion();
    }
}
