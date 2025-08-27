<?php

namespace App\Filament\Resources\TestResults\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TestResultInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('sample_id')
                    ->numeric(),
                TextEntry::make('parameter_id')
                    ->numeric(),
                TextEntry::make('test_method_id')
                    ->numeric(),
                TextEntry::make('analyst_personel_id')
                    ->numeric(),
                TextEntry::make('validator_personel_id')
                    ->numeric(),
                TextEntry::make('tested_value'),
                TextEntry::make('corrected_value'),
                TextEntry::make('unit'),
                TextEntry::make('test_date')
                    ->date(),
                TextEntry::make('standard_value_ref'),
                TextEntry::make('standard_unit_ref'),
                TextEntry::make('standard_notes_ref'),
                TextEntry::make('status'),
                TextEntry::make('validation_date')
                    ->dateTime(),
                TextEntry::make('created_by'),
                TextEntry::make('updated_by'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
