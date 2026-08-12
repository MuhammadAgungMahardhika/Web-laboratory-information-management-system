<?php

namespace App\Filament\Resources\TestResults\Actions;

use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Services\TestResultApprovalService;

use Exception;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class TestResultAction
{
    public const PERMISSION_REQUEST_VALIDATE_TEST_RESULT = 'request-validate-test-result';

    public static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }

    public static function approvalHistory(): Action
    {
        return Action::make('approvalHistory')
            ->label('Approval')
            ->button()
            ->icon(Heroicon::OutlinedClock)
            ->modalHeading('Approval')
            ->modalSubmitAction(false)
            ->slideOver()
            ->modalCancelActionLabel('Tutup')
            ->modalWidth(Width::TwoExtraLarge)
            ->schema([
                View::make('components.approval-timeline'),
            ]);
    }
    /**
     * Analis kirim hasil uji untuk divalidasi (mulai Level 1).
     * Dipakai juga untuk submit ULANG setelah status RevisionNeeded.
     */


    public static function requestValidate($url = null): Action
    {
        $authorized = static::isAuthorized(static::PERMISSION_REQUEST_VALIDATE_TEST_RESULT);

        return Action::make('Request Validasi')
            ->icon(Heroicon::ArrowUpTray)
            ->color('warning')
            ->authorize(
                fn(TestResult $record) =>
                in_array($record->status, [
                    TestResultStatusEnum::Raw->value,
                    TestResultStatusEnum::RevisionNeeded->value,
                ])
                    && $record->tested_value
                    && $authorized
            )
            ->requiresConfirmation()
            ->action(function (TestResult $record, TestResultApprovalService $service, $livewire) use ($url) {
                try {
                    $result = null;
                    DB::transaction(function () use ($service, $record, &$result) {
                        $result = $service->submitForValidation($record);
                        if (!$result['success']) {
                            throw new Exception($result['message']);
                        }
                    });

                    Notification::make()->title($result['message'] ?? "")->success()->send();

                    if ($url) {
                        return redirect()->to($url);
                    } else {
                        $livewire->mountedTableActionData = [];
                    }
                } catch (Exception $e) {
                    Notification::make()
                        ->title('Gagal request validasi hasil uji')
                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                        ->danger()
                        ->send();

                    Log::error('Gagal request validasi hasil uji', [
                        'test_result_id' => $record->id,
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id(),
                    ]);
                }
            });
    }

    /**
     * Satu tombol Validasi, otomatis nyesuaikan Level 1 / Level 2
     * berdasarkan permission user yang login dan approval yang sedang pending.
     */
    /**
     * Satu tombol Validasi, otomatis menyesuaikan Level 1 / Level 2
     * berdasarkan approval yang sedang pending untuk user yang login.
     */
    public static function validate($url = null): Action
    {
        return Action::make('Validasi')
            ->icon(Heroicon::Check)
            ->slideOver()
            ->modalWidth('6xl')
            ->color('success')
            ->visible(
                fn(
                    TestResult $record,
                    TestResultApprovalService $service
                ) => (bool) $service->getPendingApprovalForCurrentUser($record)
            )
            ->schema(
                function (
                    TestResult $record,
                    TestResultApprovalService $service
                ) {
                    $pending = $service->getPendingApprovalForCurrentUser($record);

                    /*
                 * =====================================================
                 * INFORMASI PENGUJIAN
                 * =====================================================
                 *
                 * Bagian ini read-only.
                 * Approver menggunakan informasi ini sebagai dasar
                 * menentukan hasil validasi.
                 */
                    $information = [
                        Placeholder::make('job')
                            ->label('Lab Job')
                            ->content(
                                data_get(
                                    $record,
                                    'sample.labJobItem.labJob.code',
                                    '-'
                                )
                            ),
                        Placeholder::make('product')
                            ->label('Produk Uji / Matrik')
                            ->content(
                                data_get(
                                    $record,
                                    'sample.labJobItem.description_code',
                                    '-'
                                )
                            ),

                        Placeholder::make('sample')
                            ->label('Nomor Sampel')
                            ->content(
                                data_get(
                                    $record,
                                    'sample.code',
                                    '-'
                                )
                            ),

                        Placeholder::make('parameter')
                            ->label('Parameter Uji')
                            ->content(function () use ($record) {
                                $code = data_get($record, 'parameter.code', '-');

                                $name = data_get(
                                    $record,
                                    'parameter.long_name_standard_notes',
                                    '-'
                                );

                                return new HtmlString(
                                    '<span>
                <span style="
                    display: inline-block;
                    padding: 2px 7px;
                    border-radius: 6px;
                    font-size: 11px;
                    font-weight: 600;
                    background: #e0f2fe;
                    color: #0369a1;
                    margin-right: 6px;
                ">' . e($code) . '</span>'
                                        . e($name) .
                                        '</span>'
                                );
                            }),
                        Placeholder::make('test_method')
                            ->label('Metode Uji')
                            ->content(
                                data_get(
                                    $record,
                                    'testMethod.name',
                                    '-'
                                )
                            ),

                        Placeholder::make('test_date')
                            ->label('Tanggal Uji')
                            ->content(
                                $record->test_date
                                    ? \Carbon\Carbon::parse(
                                        $record->test_date
                                    )->format('d/m/Y')
                                    : '-'
                            ),

                        Placeholder::make('analyst')
                            ->label('Analis')
                            ->content(
                                data_get(
                                    $record,
                                    'analystPersonel.fullname',
                                    '-'
                                )
                            ),
                    ];

                    /*
                 * =====================================================
                 * HASIL PENGUJIAN
                 * =====================================================
                 *
                 * Ini yang menjadi dasar perbandingan dengan BML.
                 */

                    $testResultInformation = [

                        Placeholder::make('tested_value')
                            ->label('Nilai Hasil')
                            ->content(
                                $record->tested_value ?? '-'
                            ),

                        Placeholder::make('unit')
                            ->label('Satuan')
                            ->content(
                                data_get(
                                    $record,
                                    'unit.name',
                                    $record->unit ?? '-'
                                )
                            ),
                    ];

                    /*
                 * =====================================================
                 * APPROVAL LEVEL 1
                 * =====================================================
                 */
                    if ($pending && $pending->approval_level === 1) {

                        return [
                            Section::make('Informasi Pengujian')
                                ->description(
                                    'Informasi hasil pengujian yang menjadi dasar validasi.'
                                )
                                ->schema([
                                    Grid::make([
                                        'default' => 1,
                                        'md' => 2,
                                        'xl' => 3,
                                    ])
                                        ->schema($information),
                                ]),

                            Section::make('Hasil & Validasi')
                                ->description(
                                    'Bandingkan nilai hasil pengujian dengan Baku Mutu (BML).'
                                )
                                ->schema([

                                    Grid::make([
                                        'default' => 1,
                                        'md' => 2,
                                        'xl' => 3,
                                    ])
                                        ->schema([
                                            Placeholder::make('value')
                                                ->label('Nilai Hasil')
                                                ->content(
                                                    $record->tested_value
                                                        ?? '-'
                                                ),

                                            Placeholder::make('unit')
                                                ->label('Satuan')
                                                ->content(
                                                    data_get(
                                                        $record,
                                                        'unit.name',
                                                        $record->unit ?? '-'
                                                    )
                                                ),

                                            TextInput::make('standard_notes_ref')
                                                ->label('Baku Mutu (BML)')
                                                ->default(
                                                    $record->standard_notes_ref
                                                )
                                                ->placeholder(
                                                    'Masukkan atau verifikasi baku mutu'
                                                )
                                                ->helperText(
                                                    'Baku mutu yang digunakan sebagai dasar penilaian.'
                                                )
                                                ->required()
                                                ->maxLength(255),
                                        ]),

                                    Radio::make('evaluation_status')
                                        ->label('Status Pengujian')
                                        ->options([
                                            1 => 'Sesuai Baku Mutu',
                                            2 => 'Tidak Sesuai Baku Mutu',
                                        ])
                                        ->default($record->evaluation_status)
                                        ->live()
                                        ->required()
                                        ->afterStateUpdated(
                                            function ($state, callable $set) {
                                                if ((int) $state === 1) {
                                                    $set(
                                                        'non_compliance_type',
                                                        null
                                                    );

                                                    $set(
                                                        'test_notes',
                                                        'Pengujian memenuhi baku mutu.'
                                                    );
                                                } else {
                                                    $set(
                                                        'test_notes',
                                                        ''
                                                    );
                                                }
                                            }
                                        ),

                                    Radio::make('non_compliance_type')
                                        ->label('Jenis Ketidaksesuaian')
                                        ->options([
                                            'below' => 'Di bawah baku mutu',
                                            'above' => 'Di atas baku mutu',
                                        ])
                                        ->visible(
                                            fn(callable $get) =>
                                            (int) $get('evaluation_status') === 2
                                        )
                                        ->live()
                                        ->dehydrated(false)
                                        ->required(
                                            fn(callable $get) =>
                                            (int) $get('evaluation_status') === 2
                                        )
                                        ->afterStateUpdated(
                                            function ($state, callable $set) {
                                                $notes = [
                                                    'below' =>
                                                    'Pengujian berada di bawah baku mutu.',
                                                    'above' =>
                                                    'Pengujian berada di atas baku mutu.',
                                                ];

                                                $set(
                                                    'test_notes',
                                                    $notes[$state] ?? ''
                                                );
                                            }
                                        ),

                                    Textarea::make('test_notes')
                                        ->label('Catatan Pengujian')
                                        ->default(
                                            $record->test_notes
                                        )
                                        ->rows(3)
                                        ->required(),

                                ]),
                        ];
                    }

                    /*
                 * =====================================================
                 * APPROVAL LEVEL 2
                 * =====================================================
                 *
                 * Level 2 hanya melihat hasil yang sudah ditentukan
                 * oleh Level 1.
                 */

                    return [

                        Section::make('Informasi Pengujian')
                            ->schema([
                                Grid::make(2)
                                    ->schema($information),
                            ]),

                        Section::make('Hasil Pengujian')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        ...$testResultInformation,

                                        Placeholder::make('bml')
                                            ->label('Baku Mutu (BML)')
                                            ->content(
                                                $record->standard_notes_ref
                                                    ?? '-'
                                            ),

                                        Placeholder::make(
                                            'evaluation_status'
                                        )
                                            ->label('Status Pengujian')
                                            ->content(
                                                match ((int) $record->evaluation_status) {
                                                    1 =>
                                                    'Sesuai Baku Mutu',

                                                    2 =>
                                                    'Tidak Sesuai Baku Mutu',

                                                    default =>
                                                    'Belum Ditentukan',
                                                }
                                            ),
                                    ]),
                            ]),

                        Section::make('Hasil Validasi Level 1')
                            ->schema([
                                Placeholder::make('validator')
                                    ->label('Validator Level 1')
                                    ->content(
                                        data_get(
                                            $record,
                                            'validatorPersonel.fullname',
                                            '-'
                                        )
                                    ),

                                Placeholder::make('validation_notes')
                                    ->label('Catatan Pengujian')
                                    ->content(
                                        $record->test_notes ?? '-'
                                    ),
                            ]),
                    ];
                }
            )

            ->requiresConfirmation()

            ->action(
                function (
                    TestResult $record,
                    array $data,
                    TestResultApprovalService $service
                ) use ($url) {

                    try {

                        $personel = $service->getPersonelFromAuth();

                        if (!$personel) {
                            throw new Exception(
                                'Data personel untuk user ini tidak ditemukan.'
                            );
                        }

                        $result = null;

                        DB::transaction(
                            function () use (
                                $service,
                                $record,
                                $personel,
                                $data,
                                &$result
                            ) {

                                $result = $service->accept(
                                    $record,
                                    $personel->id,
                                    null,
                                    $data
                                );

                                if (!$result['success']) {
                                    throw new Exception(
                                        $result['message']
                                    );
                                }
                            }
                        );

                        Notification::make()
                            ->title(
                                $result['message']
                                    ?? 'Validasi berhasil.'
                            )
                            ->success()
                            ->send();

                        if ($url) {
                            return redirect()->to($url);
                        }
                    } catch (Exception $e) {

                        Notification::make()
                            ->title('Gagal validasi hasil uji')
                            ->body(
                                'Terjadi kesalahan: '
                                    . $e->getMessage()
                            )
                            ->danger()
                            ->send();

                        Log::error(
                            'Gagal validasi hasil uji',
                            [
                                'test_result_id' => $record->id,
                                'error' => $e->getMessage(),
                                'user_id' => Auth::id(),
                            ]
                        );
                    }
                }
            );
    }
    /**
     * Perlu Revisi.
     * Level 1 -> balik ke analis. Level 2 -> balik ke Level 1 saja (tidak ke analis).
     * Logikanya sepenuhnya ditentukan service berdasarkan level approval yang pending.
     */
    public static function revisionNeeded($url = null): Action
    {
        return Action::make('Perlu Revisi')
            ->icon('heroicon-o-pencil-square')
            ->color('warning')
            ->visible(fn(TestResult $record, TestResultApprovalService $service) =>
            (bool) $service->getPendingApprovalForCurrentUser($record))
            ->schema([
                Textarea::make('comment')
                    ->label('Alasan Revisi')
                    ->placeholder('Jelaskan mengapa hasil uji ini perlu direvisi.')
                    ->required()
                    ->rows(4),
            ])
            ->requiresConfirmation()
            ->action(function (TestResult $record, array $data, TestResultApprovalService $service) use ($url) {
                try {
                    $personel = $service->getPersonelFromAuth();
                    if (!$personel) {
                        throw new Exception('Data personel untuk user ini tidak ditemukan.');
                    }

                    $result = null;
                    DB::transaction(function () use ($service, $record, $personel, $data, &$result) {
                        $result = $service->requestRevision($record, $personel->id, $data['comment']);
                        if (!$result['success']) {
                            throw new Exception($result['message']);
                        }
                    });

                    Notification::make()->title($result['message'] ?? "")->success()->send();

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
        return Action::make('Tolak')
            ->icon(Heroicon::XCircle)
            ->color('danger')
            ->schema([
                Textarea::make('comment')
                    ->label('Alasan ditolak')
                    ->placeholder('Jelaskan mengapa hasil uji ini perlu ditolak.')
                    ->required()
                    ->rows(4),
            ])
            ->visible(fn(TestResult $record, TestResultApprovalService $service) =>
            (bool) $service->getPendingApprovalForCurrentUser($record))
            ->requiresConfirmation()
            ->action(function (TestResult $record, array $data, TestResultApprovalService $service) use ($url) {
                try {
                    $personel = $service->getPersonelFromAuth();
                    if (!$personel) {
                        throw new Exception('Data personel untuk user ini tidak ditemukan.');
                    }

                    $result = null;
                    DB::transaction(function () use ($service, $record, $personel, $data, &$result) {
                        $result = $service->reject($record, $personel->id, $data['comment']);
                        if (!$result['success']) {
                            throw new Exception($result['message']);
                        }
                    });

                    Notification::make()->title($result['message'] ?? "")->success()->send();

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

    // ==================== BULK ACTIONS ====================

    public static function bulkRequestValidate(): BulkAction
    {
        return BulkAction::make('requestValidate')
            ->label('Request Validasi')
            ->icon(Heroicon::ArrowUpTray)
            ->requiresConfirmation()
            ->authorize(fn() => TestResultAction::isAuthorized(TestResultAction::PERMISSION_REQUEST_VALIDATE_TEST_RESULT))
            ->color('warning')
            ->action(function (Collection $records, TestResultApprovalService $service) {
                $successCount = 0;
                $failedCount = 0;
                foreach ($records as $record) {
                    try {
                        if (in_array($record->status, [
                            TestResultStatusEnum::Raw->value,
                            TestResultStatusEnum::RevisionNeeded->value,
                        ])) {
                            DB::transaction(function () use ($service, $record) {
                                $result = $service->submitForValidation($record);
                                if (!$result['success']) throw new Exception($result['message']);
                            });
                            $successCount++;
                        } else {
                            throw new Exception();
                        }
                    } catch (Exception $e) {
                        $failedCount++;
                    }
                }
                self::bulkNotify($successCount, $failedCount, 'Request Validasi Berhasil', 'hasil uji berhasil untuk request validasi.', 'Request Validasi Gagal', 'hasil uji gagal untuk request validasi.');
            })
            ->deselectRecordsAfterCompletion();
    }

    public static function bulkValidate(): BulkAction
    {
        return BulkAction::make('validate')
            ->label('Validasi')
            ->icon(Heroicon::Check)
            ->requiresConfirmation()
            ->schema(function (TestResultApprovalService $service) {

                if ($service->canApproveLevel(1)) {
                    return [
                        Radio::make('evaluation_status')
                            ->label('Status Pengujian')
                            ->options([
                                1 => 'Sesuai Baku Mutu',
                                2 => 'Tidak Sesuai Baku Mutu',
                            ])
                            ->default(1)
                            ->required(),

                        Textarea::make('test_notes')
                            ->required()
                            ->label('Catatan Pengujian')
                            ->rows(3),
                    ];
                }

                return [
                    Textarea::make('comment')
                        ->required()
                        ->label('Catatan Pengujian')
                        ->rows(3),
                ];
            })
            ->color('success')
            ->visible(function (TestResultApprovalService $service) {
                return $service->canApproveLevel(1)
                    || $service->canApproveLevel(2);
            })
            ->action(function (
                Collection $records,
                array $data,
                TestResultApprovalService $service
            ) {

                $personel = $service->getPersonelFromAuth();

                if (! $personel) {
                    throw new Exception('Data personel tidak ditemukan.');
                }

                $successCount = 0;
                $failedCount = 0;

                foreach ($records as $record) {
                    try {
                        DB::transaction(function () use ($service,  $record, $personel, $data) {
                            $result = $service->accept($record,  $personel->id,   null, $data);
                            if (! $result['success']) {
                                throw new Exception($result['message']);
                            }
                        });

                        $successCount++;
                    } catch (Exception $e) {
                        $failedCount++;
                    }
                }

                self::bulkNotify($successCount, $failedCount, 'Validasi Berhasil', 'hasil uji berhasil divalidasi.', 'Validasi Gagal', 'hasil uji gagal divalidasi.');
            })
            ->deselectRecordsAfterCompletion();
    }

    public static function bulkRevisionNeeded(): BulkAction
    {
        return BulkAction::make('revision_needed')
            ->label('Perlu Revisi')
            ->icon(Heroicon::PencilSquare)
            ->visible(function (TestResultApprovalService $service) {
                return $service->canApproveLevel(1)
                    || $service->canApproveLevel(2);
            })
            ->schema([
                Textarea::make('comment')
                    ->label('Alasan Revisi')
                    ->placeholder('Jelaskan mengapa hasil uji ini perlu direvisi secara massal.')
                    ->required()
                    ->rows(4),
            ])
            ->requiresConfirmation()
            ->color('warning')
            ->action(function (Collection $records, array $data, TestResultApprovalService $service) {
                $personel = $service->getPersonelFromAuth();
                $successCount = 0;
                $failedCount = 0;
                foreach ($records as $record) {
                    try {
                        if (!$personel) throw new Exception('Data personel tidak ditemukan.');
                        DB::transaction(function () use ($service, $record, $personel, $data) {
                            $result = $service->requestRevision($record, $personel->id, $data['comment']);
                            if (!$result['success']) throw new Exception($result['message']);
                        });
                        $successCount++;
                    } catch (Exception $e) {
                        $failedCount++;
                    }
                }
                self::bulkNotify($successCount, $failedCount, 'Berhasil menandai status menjadi revisi', 'hasil uji ditandai sebagai revisi.', 'Gagal menandai status menjadi revisi', 'hasil uji gagal ditandai sebagai revisi.');
            })
            ->deselectRecordsAfterCompletion();
    }

    public static function bulkReject(): BulkAction
    {
        return BulkAction::make('reject')
            ->label('Tolak Pengujian')
            ->icon(Heroicon::XCircle)
            ->schema([
                Textarea::make('comment')
                    ->label('Alasan ditolak')
                    ->required()
                    ->rows(4),
            ])
            ->requiresConfirmation()
            ->visible(function (TestResultApprovalService $service) {
                return $service->canApproveLevel(1)
                    || $service->canApproveLevel(2);
            })
            ->color('danger')
            ->action(function (Collection $records, array $data, TestResultApprovalService $service) {
                $personel = $service->getPersonelFromAuth();
                $successCount = 0;
                $failedCount = 0;
                foreach ($records as $record) {
                    try {
                        if (!$personel) throw new Exception('Data personel tidak ditemukan.');
                        DB::transaction(function () use ($service, $record, $personel, $data) {
                            $result = $service->reject($record, $personel->id, $data['comment']);
                            if (!$result['success']) throw new Exception($result['message']);
                        });
                        $successCount++;
                    } catch (Exception $e) {
                        $failedCount++;
                    }
                }
                self::bulkNotify($successCount, $failedCount, 'Berhasil menandai status menjadi ditolak', 'hasil uji ditandai sebagai ditolak.', 'Gagal menandai status menjadi ditolak', 'hasil uji gagal ditandai sebagai ditolak.');
            })
            ->deselectRecordsAfterCompletion();
    }

    private static function bulkNotify(int $success, int $failed, string $successTitle, string $successBody, string $failedTitle, string $failedBody): void
    {
        if ($success > 0) {
            Notification::make()->title($successTitle)->body("{$success} {$successBody}")->success()->send();
        }
        if ($failed > 0) {
            Notification::make()->title($failedTitle)->body("{$failed} {$failedBody}")->danger()->send();
        }
    }
}
