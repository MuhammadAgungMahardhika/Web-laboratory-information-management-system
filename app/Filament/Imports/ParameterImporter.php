<?php

namespace App\Filament\Imports;

use App\Models\Parameter;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class ParameterImporter extends Importer
{
    protected static ?string $model = Parameter::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('test_method_id')
                ->numeric()
                ->requiredMapping()
                ->label('Id metode uji')
                ->rules(['nullable', 'integer']),
            ImportColumn::make('id')
                ->requiredMapping()
                ->helperText('parameter di update berdasarkan id')
                ->label('Id parameter')
                ->rules(['required', 'integer']),
            ImportColumn::make('code')
                ->requiredMapping()
                ->label('Kode parameter')
                ->rules(['required', 'max:255']),
            ImportColumn::make('long_name')
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
                ->rules(['required', 'numeric', 'min:0']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('standard_notes')
                ->label('BML')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): Parameter
    {
        $parameter = Parameter::firstOrNew([
            'id' => $this->data['id'],
        ]);

        // Set created_by untuk record baru (trait Blameable akan handle ini juga)
        if (!$parameter->exists) {
            $parameter->created_by = $this->getImportSource();
        }

        // Selalu update updated_by
        $parameter->updated_by = $this->getImportSource();

        return $parameter;
    }

    /**
     * Override save method untuk memastikan timestamps di-set
     */
    protected function save(): void
    {
        $this->record->save();
    }

    /**
     * Generate sumber import
     */
    protected function getImportSource(): string
    {
        $user = Auth::user();

        if ($user) {
            return "Import by {$user->name}";
        }

        return 'Import System';
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
