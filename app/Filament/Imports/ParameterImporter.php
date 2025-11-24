<?php

namespace App\Filament\Imports;

use App\Models\Parameter;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ParameterImporter extends Importer
{
    protected static ?string $model = Parameter::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('test_method_id')
                ->numeric()
                ->label('Id metode uji')
                ->rules(['integer']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->label('Nama parameter')
                ->rules(['required', 'max:255']),
            ImportColumn::make('unit')
                ->requiredMapping()
                ->label('Satuan')
                ->rules(['required', 'max:50']),
            ImportColumn::make('description')
                ->label('Deskripsi'),
            ImportColumn::make('default_price')
                ->label('Harga')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('standard_max_value')
                ->numeric()
                ->label('Batas atas baku mutu')
                ->rules(['integer']),
            ImportColumn::make('standard_min_value')
                ->numeric()
                ->label('Batas bawah baku mutu')
                ->rules(['integer']),
            ImportColumn::make('standard_unit')
                ->label('Satuan standar')
                ->rules(['max:50']),
            ImportColumn::make('standard_notes')
                ->label('Catatan')
                ->rules(['max:255']),
            ImportColumn::make('created_by')
                ->rules(['max:255']),
            ImportColumn::make('updated_by')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): Parameter
    {
        return Parameter::firstOrNew([
            'id' => $this->data['id'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your parameter import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
