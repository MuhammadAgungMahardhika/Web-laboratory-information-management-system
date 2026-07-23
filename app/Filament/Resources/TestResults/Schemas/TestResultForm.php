<?php

namespace App\Filament\Resources\TestResults\Schemas;

use App\Models\Enums\TestResultApprovalStatusEnum;
use App\Models\Enums\TestResultEvaluationStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Services\TestResultApprovalService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class TestResultForm
{
    /**
     * User dianggap "approver" kalau punya salah satu permission
     * approve-test-result-level-*. Cuma approver yang boleh lihat BML & hasil evaluasi.
     */
    public static function isApprover(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        foreach (TestResultApprovalService::LEVEL_PERMISSIONS as $permission) {
            if ($user->can($permission)) {
                return true;
            }
        }

        return false;
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Hasil Uji')
                            ->schema([

                                // ================= SECTION KHUSUS APPROVER =================
                                // Analis tidak pernah melihat section ini sama sekali (BML & hasil
                                // evaluasi disembunyikan total, bukan cuma disabled, biar tidak bias
                                // saat analis menginput nilai).
                                Section::make([
                                    TextInput::make('standard_notes_ref')
                                        ->label('Baku Mutu (BML)')
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->helperText('Diisi/diverifikasi oleh approver saat validasi Level 1.'),

                                    Radio::make('evaluation_status')
                                        ->options(TestResultEvaluationStatusEnum::labels())
                                        ->inline()
                                        ->hintIcon(Heroicon::InformationCircle)
                                        ->hintIconTooltip('Ditentukan otomatis dari keputusan approver saat Validasi Level 1.')
                                        ->label('Status Evaluasi')
                                        ->columnSpanFull(),
                                    Textarea::make('comment')
                                        ->label('Catatan Approval')
                                        ->autosize()
                                        ->columnSpanFull(),

                                    TextInput::make('revision_count')
                                        ->label('Jumlah Revisi')
                                        ->numeric(),

                                    DateTimePicker::make('validation_date')
                                        ->visible(fn($record) => $record && $record->validation_date !== null)
                                        ->label('Tanggal Valid'),

                                    Select::make('validator_personel_id')
                                        ->label('Validator')
                                        ->visible(fn($record) => $record && $record->validator_personel_id !== null)
                                        ->relationship('validatorPersonel', 'fullname'),


                                ])
                                    ->columns(1)
                                    ->inlineLabel()
                                    ->disabled() // read-only murni, keputusan ada di tombol Validasi/Revisi/Tolak
                                    ->dehydrated(false)
                                    ->heading(function ($record) {
                                        if (!$record?->evaluation_status) {
                                            return new HtmlString(
                                                'Status Evaluasi -> <span style="color:#6B7280;font-weight:700">Belum Divalidasi</span>'
                                            );
                                        }

                                        return new HtmlString(sprintf(
                                            'Status Evaluasi -> <span style="color:%s;font-weight:700">%s</span>',
                                            TestResultEvaluationStatusEnum::cssColor($record->evaluation_status),
                                            TestResultEvaluationStatusEnum::labels()[$record->evaluation_status]
                                        ));
                                    })
                                    ->visibleOn(['view', 'edit'])
                                    ->visible(fn() => static::isApprover()),

                                // ================= CATATAN REVISI (KHUSUS ANALIS) =================
                                // Analis tidak lihat BML/evaluation_status, tapi kalau statusnya
                                // RevisionNeeded, dia perlu tahu alasannya.
                                Section::make([
                                    Textarea::make('comment')
                                        ->label('Alasan Perlu Revisi')
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->columnSpanFull(),
                                ])
                                    ->heading('Catatan Revisi dari Approver')
                                    ->visible(
                                        fn($record) =>
                                        !static::isApprover()
                                            && $record
                                            && $record->status === TestResultStatusEnum::RevisionNeeded->value
                                    )
                                    ->visibleOn(['view', 'edit']),

                                // ================= SECTION UTAMA: DATA HASIL UJI (ANALIS) =================
                                Section::make([
                                    Select::make('sample_id')
                                        ->label('Kode Sampel')
                                        ->relationship('sample', 'sample_code')
                                        ->required()
                                        ->searchable()
                                        ->disabledOn(['view', 'edit'])
                                        ->preload(),

                                    Select::make('parameter_id')
                                        ->label('Parameter')
                                        ->required()
                                        ->relationship('parameter', 'code', modifyQueryUsing: function ($query, Get $get) {
                                            $sampleId = $get('sample_id');

                                            $query->whereHas('parameterLabJobItems', function ($q) use ($sampleId) {
                                                return $q->whereHas('labJobItem', function ($a) use ($sampleId) {
                                                    return $a->whereHas('samples', function ($b) use ($sampleId) {
                                                        return $b->where('id', $sampleId);
                                                    });
                                                });
                                            });
                                        })
                                        ->searchable()
                                        ->disabledOn(['view', 'edit'])
                                        ->preload(),

                                    DatePicker::make('test_date')
                                        ->default(now())
                                        ->disabled()
                                        ->dehydrated()
                                        ->label('Tanggal Uji')
                                        ->minDate(now()->toDateString())
                                        ->required()
                                        ->afterStateHydrated(function ($state, callable $set) {
                                            if (empty($state)) {
                                                $set('test_date', now()->toDateString());
                                            }
                                        }),

                                    Select::make('analyst_personel_id')
                                        ->label('Analis')
                                        ->default(Auth::user()->personel_id)
                                        ->relationship('analystPersonel', 'fullname', modifyQueryUsing: fn($query) => $query->where('id', Auth::user()->personel->id))
                                        ->searchable()
                                        ->preload()
                                        ->disabled()
                                        ->dehydrated()
                                        ->afterStateHydrated(function ($state, callable $set) {
                                            if (empty($state)) {
                                                $set('analyst_personel_id', Auth::user()->personel_id);
                                            }
                                        }),

                                    TextInput::make('tested_value')
                                        ->label('Nilai')
                                        ->required()
                                        ->autofocus()
                                        ->copyable()
                                        ->live(),

                                    Select::make('test_method_id')
                                        ->label('Metode Uji')
                                        ->required()
                                        ->relationship('testMethod', 'name')
                                        ->searchable()
                                        ->preload(),

                                    TextInput::make('unit')
                                        ->label('Satuan')
                                        ->copyable()
                                        ->live()
                                        ->required(),

                                    Textarea::make('test_notes')
                                        ->columnSpanFull()
                                        ->label('Catatan Pengujian'),

                                ])->columns(1)->inlineLabel()->heading(function ($record) {
                                    if (!$record?->status) {
                                        return new HtmlString(
                                            'Status Hasil Uji -> <span style="color:#6B7280;font-weight:600">Belum Diuji</span>'
                                        );
                                    }

                                    return new HtmlString(sprintf(
                                        'Status Hasil Uji -> <span style="color:%s;font-weight:700">%s</span>',
                                        TestResultStatusEnum::cssColor($record->status),
                                        TestResultStatusEnum::labels()[$record->status]
                                    ));
                                }),



                            ])->columnSpanFull()->columns(2)->visibleOn(['view', 'edit']),

                        Tab::make('Riwayat Approval')
                            ->schema([
                                Section::make([
                                    Repeater::make('test_result_approvals')
                                        ->relationship('test_result_approvals')
                                        ->hiddenLabel()
                                        ->table([
                                            TableColumn::make('Level'),
                                            TableColumn::make('Status'),
                                            TableColumn::make('Petugas'),
                                            TableColumn::make('Catatan'),
                                            TableColumn::make('Waktu'),

                                        ])
                                        ->schema([
                                            TextInput::make('approval_level')
                                                ->label('Level'),

                                            Select::make('status')
                                                ->label('Status')
                                                ->options([
                                                    TestResultApprovalStatusEnum::Pending->value => 'Menunggu',
                                                    TestResultApprovalStatusEnum::Accepted->value => 'Disetujui',
                                                    TestResultApprovalStatusEnum::Rejected->value => 'Ditolak',
                                                    TestResultApprovalStatusEnum::Revision->value => 'Perlu Revisi',
                                                ]),

                                            Select::make('personel_id')
                                                ->label('Petugas')
                                                ->relationship('personel', 'fullname'),

                                            Textarea::make('note')
                                                ->label('Catatan')
                                                ->columnSpanFull(),

                                            DateTimePicker::make('updated_at')
                                                ->label('Waktu'),
                                        ])
                                        ->columns(5)
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->deletable(false)
                                        ->addable(false)
                                        ->reorderable(false)
                                        ->collapsible()
                                        ->itemLabel(function (array $state) {
                                            $status = match ($state['status'] ?? null) {
                                                TestResultApprovalStatusEnum::Pending->value => 'Menunggu',
                                                TestResultApprovalStatusEnum::Accepted->value => 'Disetujui',
                                                TestResultApprovalStatusEnum::Rejected->value => 'Ditolak',
                                                TestResultApprovalStatusEnum::Revision->value => 'Perlu Revisi',
                                                default => '-',
                                            };
                                            return "Level " . ($state['approval_level'] ?? '-') . " — {$status}";
                                        }),
                                ])
                                    ->heading('Riwayat Approval')
                                    ->collapsible()
                                    ->columnSpanFull()
                                    ->visibleOn(['view', 'edit']),
                            ]),

                    ])->columnSpanFull(),


            ]);
    }
}
