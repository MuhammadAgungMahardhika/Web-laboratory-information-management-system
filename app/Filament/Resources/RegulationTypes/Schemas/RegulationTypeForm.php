<?php

namespace App\Filament\Resources\RegulationTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RegulationTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Jenis regulasi')
                    ->maxLength(15)
                    ->required(),

                TextInput::make('long_name')
                    ->label('Jenis regulasi lengkap')
                    ->required(),

            ]);
    }
}
