<?php

namespace App\Filament\Resources\TestResults\Schemas;

use App\Models\Enums\PositionEnum;
use App\Models\Enums\RoleEnum;
use App\Models\Enums\TestResultEvaluationStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Services\TestResultService;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class TestResultForm
{
    public const PERMISSION_EVALUATE_STATUS_TEST_RESULT =  'evaluate-status-test-result';

    public static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
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
                Section::make([
                    Section::make([
                        Select::make('sample_id')
                            ->label('Sampel')
                            ->relationship('sample', 'sample_code')
                            ->required()
                            ->searchable()
                            ->disabledOn(['view', 'edit'])
                            ->preload(),
                        Select::make('parameter_id')
                            ->label('Parameter')
                            ->required()
                            ->relationship('parameter', 'name', modifyQueryUsing: function ($query, Get $get) {
                                $sampleId =   $get('sample_id');

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

                        Select::make('test_method_id')
                            ->label('Metode Uji')
                            ->required()
                            ->relationship('testMethod', 'name')
                            ->searchable()
                            ->preload(),

                    ])->columns(3)->heading(fn($record) => $record?->status ? 'Status -> ' . TestResultStatusEnum::labels()[$record->status] : 'Status -> Belum dibuat')->collapsible(),
                    Section::make([
                        Radio::make('evaluation_status')
                            // ->visible(fn() => static::isAuthorized(static::PERMISSION_EVALUATE_STATUS_TEST_RESULT))
                            ->options(TestResultEvaluationStatusEnum::labels())->columnSpanFull()
                            ->inline()->hintIcon(Heroicon::InformationCircle)->hintIconTooltip('Status evaluasi hasil uji, apakah hasil uji memenuhi standar/baku mutu atau tidak.')->label('Status Evaluasi'),
                        TextInput::make('revision_count')
                            ->label('Jumlah Revisi')
                            ->numeric()
                            ->default(0),
                        DateTimePicker::make('validation_date')
                            ->label('Tanggal Validasi'),
                        Select::make('validator_personel_id')
                            ->label('Validator')
                            ->relationship('validatorPersonel', 'fullname')
                            ->searchable(),
                        Textarea::make('comment')->label('Komentar')->autosize()->columnSpanFull()
                    ])->columns(3)->heading(fn($record) => $record?->evaluation_status ? 'Status Evaluasi -> ' . TestResultEvaluationStatusEnum::labels()[$record->evaluation_status] : 'Status Evaluasi -> Belum evaluasi')->disabled()->collapsible()->collapsed()->visibleOn(['view', 'edit']),
                ])->columns(2)->columnSpanFull(),

                Section::make([
                    Section::make([
                        Select::make('analyst_personel_id')
                            ->label('Analis')
                            ->relationship('analystPersonel', 'fullname', modifyQueryUsing: fn($query) => $query->where('id', Auth::user()->personel->id))
                            ->searchable()
                            ->preload(),
                        DatePicker::make('test_date')
                            ->default(now())
                            ->label('Tanggal Uji')
                            ->minDate(now()->toDateString())
                            ->required(),


                        TextInput::make('tested_value')
                            ->label('Nilai')
                            ->numeric()
                            ->required()
                            ->copyable()
                            ->live(),

                        TextInput::make('unit')
                            ->label('Satuan')
                            ->copyable()
                            ->live()
                            ->required(),
                        Textarea::make('test_notes')
                            ->columnSpanFull()
                            ->label('Catatan Pengujian'),

                    ])->columns(1)->inlineLabel(),
                    Section::make([
                        TextInput::make('standard_max_value_ref')
                            ->label('Nilai Standar Maksimum')
                            ->numeric(),
                        TextInput::make('standard_min_value_ref')
                            ->label('Nilai Standar Minimum')
                            ->numeric(),
                        TextInput::make('standard_unit_ref')
                            ->label('Satuan Standar'),
                        TextInput::make('standard_notes_ref')
                            ->label('Catatan Standar')
                    ])->heading('Standar Referensi ( Baku Mutu )')->columns(1)->inlineLabel(),
                ])->columnSpanFull()->columns(2)->heading(
                    'Hasil Uji'
                )->visibleOn(['view', 'edit']),

            ]);
    }
}
