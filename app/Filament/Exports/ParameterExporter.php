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
            ExportColumn::make('test_method.name'),
            ExportColumn::make('name'),
            ExportColumn::make('unit'),
            ExportColumn::make('description'),
            ExportColumn::make('default_price'),
            ExportColumn::make('status'),
            ExportColumn::make('standard_max_value'),
            ExportColumn::make('standard_min_value'),
            ExportColumn::make('standard_unit'),
            ExportColumn::make('standard_notes'),
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
