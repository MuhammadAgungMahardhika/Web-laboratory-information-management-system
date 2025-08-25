<?php

namespace App\Filament\Resources\TestResults\Schemas;

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
use Filament\Schemas\Schema;

class TestResultForm
{
    public static function configure(Schema $schema): Schema
    {
        $isDisabled = Auth::user()->hasRole(RoleEnum::SuperAdmin->value) ? true : true;
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                Section::make([
                    Select::make('validation_status')
                        ->label('Status')
                        ->options(TestResultStatusEnum::labels())
                        ->default(TestResultStatusEnum::Raw->value)
                        ->required(),
                    Select::make('sample_id')
                        ->hidden($isDisabled)
                        ->label('Sampel')
                        ->relationship('sample', 'sample_code')
                        ->required()
                        ->searchable()
                        ->preload(),
                    Select::make('parameter_id')
                        ->label('Parameter')
                        ->required()
                        ->relationship('parameter', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('analyst_personel_id')
                        ->label('Analis')
                        ->relationship('analystPersonel', 'fullname')
                        ->searchable()
                        ->preload(),
                ])->columnSpanFull()->heading('Detail Pengujian')->columns(4)->disabled($isDisabled),
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
                            ->label('Skor')
                            ->required(),
                        TextInput::make('corrected_value')
                            ->label('Skor Koreksi'),
                        TextInput::make('unit')
                            ->label('Satuan')
                            ->required(),
                        Textarea::make('test_notes')
                            ->columnSpanFull()
                            ->label('Catatan Pengujian'),
                    ])->columns(1)->inlineLabel(),
                    Section::make([
                        TextInput::make('standard_value_ref')
                            ->label('Nilai Standar Referensi'),
                        TextInput::make('standard_unit_ref')
                            ->label('Satuan Standar Referensi'),
                        TextInput::make('standard_notes_ref')
                            ->label('Catatan Standar Referensi')
                    ])->heading('Standar Referensi')->columns(1)->inlineLabel(),
                ])->columnSpanFull()->columns(2)->heading('Hasil Uji'),

                Section::make([
                    DateTimePicker::make('validation_date')
                        ->label('Tanggal Validasi'),
                    Select::make('validator_personel_id')
                        ->label('Validator')
                        ->relationship('validatorPersonel', 'fullname')
                        ->searchable()
                        ->preload(),
                ])->columnSpanFull()->heading('Validasi')->columns(2),
            ]);
    }
}
