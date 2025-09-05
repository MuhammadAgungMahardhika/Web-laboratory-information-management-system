<?php

namespace App\Filament\Resources\TestResults\Schemas;

use App\Models\Enums\PositionEnum;
use App\Models\Enums\RoleEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use Auth;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class TestResultForm
{
    public static function configure(Schema $schema): Schema
    {
        $fillingTestResult = Auth::user()->can('filling-test-result');
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                Section::make([
                    Select::make('status')
                        ->label('Status')
                        ->options(TestResultStatusEnum::labels())
                        ->default(TestResultStatusEnum::Raw->value)
                        ->required(),
                    Select::make('sample_id')
                        ->label('Sampel')
                        ->relationship('sample', 'sample_code')
                        ->required()
                        ->searchable()
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
                        ->preload(),
                    Select::make('analyst_personel_id')
                        ->label('Analis')
                        ->relationship('analystPersonel', 'fullname')
                        ->searchable()
                        ->preload(),
                ])->columnSpanFull()->heading(fn($record) => $record ? 'Status -> ' . TestResultStatusEnum::labels()[$record->status] : 'Detail Pengujian')->columns(4)->disabledOn('edit')->collapsible()->iconColor(fn($record) =>  $record && $record->status ? TestResultStatusEnum::color($record->status) : 'primary')->icon(Heroicon::Beaker),
                Section::make([
                    Section::make([
                        DatePicker::make('test_date')
                            ->default(now())
                            ->label('Tanggal Pengujian')
                            ->required(),
                        Select::make('test_method_id')
                            ->label('Metode Uji')
                            ->required()
                            ->relationship('testMethod', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('tested_value')
                            ->label('Nilai')
                            ->numeric()
                            ->required(),
                        TextInput::make('corrected_value')
                            ->label('Nilai Koreksi')
                            ->numeric(),
                        TextInput::make('unit')
                            ->label('Satuan')
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
                ])->columnSpanFull()->columns(2)->heading('Hasil Uji')->visible(fn() => $fillingTestResult),

                Section::make([
                    DateTimePicker::make('validation_date')
                        ->label('Tanggal Validasi')
                        ->disabled(),
                    Select::make('validator_personel_id')
                        ->label('Validator')
                        ->relationship('validatorPersonel', 'fullname')
                        ->searchable()
                        ->preload()
                        ->disabled(),
                ])->columnSpanFull()->heading('Validasi')->columns(2),
            ]);
    }
}
