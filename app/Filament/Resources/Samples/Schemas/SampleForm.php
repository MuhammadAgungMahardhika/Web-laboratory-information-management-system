<?php

namespace App\Filament\Resources\Samples\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class SampleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('lab_job_item_id')
                    ->required()
                    ->numeric(),
                TextInput::make('collected_by_personel_id')
                    ->numeric(),
                TextInput::make('received_by_personel_id')
                    ->numeric(),
                TextInput::make('sample_code')
                    ->required(),
                DatePicker::make('collection_date')
                    ->required(),
                TimePicker::make('collection_time')
                    ->required(),
                Textarea::make('collection_location_desc')
                    ->columnSpanFull(),
                TextInput::make('latitude'),
                TextInput::make('longitude'),
                TextInput::make('container_type'),
                TextInput::make('container_quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('sample_volume'),
                TextInput::make('preservation_method'),
                Textarea::make('collection_notes')
                    ->columnSpanFull(),
                DatePicker::make('received_date')
                    ->required(),
                TimePicker::make('received_time')
                    ->required(),
                Textarea::make('received_condition_notes')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'received' => 'Received',
            'prepared' => 'Prepared',
            'in_analysis' => 'In analysis',
            'analysis_completed' => 'Analysis completed',
            'invalid' => 'Invalid',
            'archived' => 'Archived',
        ])
                    ->default('received')
                    ->required(),
                TextInput::make('created_by'),
                TextInput::make('updated_by'),
            ]);
    }
}
