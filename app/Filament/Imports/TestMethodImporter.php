<?php

namespace App\Filament\Imports;

use App\Models\TestMethod;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class TestMethodImporter extends Importer
{
    protected static ?string $model = TestMethod::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->requiredMapping()
                ->helperText('metode uji di update berdasarkan id')
                ->label('Id metode uji')
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->label('Nama metode uji')
                ->rules(['max:255']),
            ImportColumn::make('description')
                ->label('Keterangan'),
            ImportColumn::make('created_by')
                ->rules(['max:255']),
            ImportColumn::make('updated_by')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): TestMethod
    {
        return TestMethod::firstOrNew([
            'id' => $this->data['id'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your test method import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
