<?php

namespace App\Filament\Exports;

use App\Models\TestMethod;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class TestMethodExporter extends Exporter
{
    protected static ?string $model = TestMethod::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Id metode uji'),
            ExportColumn::make('name')->label('Nama metode uji'),
            ExportColumn::make('description')->label('Keterangan'),
            ExportColumn::make('created_by'),
            ExportColumn::make('updated_by'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your test method export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
