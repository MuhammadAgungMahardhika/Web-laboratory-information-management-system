<?php

namespace App\Filament\Resources\TestResults\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TestResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sample_id')
                    ->required()
                    ->numeric(),
                TextInput::make('parameter_id')
                    ->required()
                    ->numeric(),
                TextInput::make('test_method_id')
                    ->required()
                    ->numeric(),
                TextInput::make('analyst_personel_id')
                    ->required()
                    ->numeric(),
                TextInput::make('validator_personel_id')
                    ->numeric(),
                TextInput::make('tested_value'),
                TextInput::make('corrected_value'),
                TextInput::make('unit')
                    ->required(),
                DatePicker::make('test_date')
                    ->required(),
                Textarea::make('test_notes')
                    ->columnSpanFull(),
                TextInput::make('standard_value_ref'),
                TextInput::make('standard_unit_ref'),
                TextInput::make('standard_notes_ref'),
                Select::make('validation_status')
                    ->options([
            'raw' => 'Raw',
            'validated' => 'Validated',
            'clarification_needed' => 'Clarification needed',
            'revision_needed' => 'Revision needed',
            'rejected' => 'Rejected',
        ])
                    ->default('raw')
                    ->required(),
                DateTimePicker::make('validation_date'),
                TextInput::make('created_by'),
                TextInput::make('updated_by'),
            ]);
    }
}
