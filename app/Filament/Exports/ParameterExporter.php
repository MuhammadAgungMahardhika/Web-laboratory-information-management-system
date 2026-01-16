<?php

namespace App\Filament\Exports;

use App\Models\Parameter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ParameterExporter extends Exporter
{
    protected static ?string $model = Parameter::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('test_method_id')->label('Id metode uji'),
            ExportColumn::make('id')->label('Id parameter'),
            ExportColumn::make('code')->label('Kode parameter'),
            ExportColumn::make('long_name')->label('Nama parameter'),
            ExportColumn::make('unit')->label('Satuan'),
            ExportColumn::make('description')->label('Deskripsi'),
            ExportColumn::make('default_price')->label('Harga'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('standard_notes')->label('Baku Mutu (BML)'),
            ExportColumn::make('created_by'),
            ExportColumn::make('updated_by'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your parameter export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
