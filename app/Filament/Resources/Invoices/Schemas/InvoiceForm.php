<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lab_job_id')
                    ->relationship('labJob', 'job_number')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('invoice_number')
                    ->required(),
                DatePicker::make('invoice_date')
                    ->required(),
                DatePicker::make('due_date')
                    ->required(),
                TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('tax_rate')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
