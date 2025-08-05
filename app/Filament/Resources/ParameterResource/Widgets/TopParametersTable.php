<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\ParameterQuotationItem; // Pastikan model ParameterQuotationItem diimpor
use App\Models\QuotationItem; // Diperlukan untuk join
use App\Models\Enums\QuotationStatusEnum; // Pastikan ini diimpor
use App\Models\Parameter; // Diperlukan untuk eager load
use Illuminate\Database\Eloquent\Model;

class TopParametersTable extends TableWidget
{
    protected static ?string $heading = '5 Parameter Paling Sering Diminta (Penawaran Diterima)';
    protected static ?string $pollingInterval = null;

    protected function getTableQuery(): Builder
    {
        // Gabungkan tabel parameter_quotation_item -> quotation_items -> quotations
        return ParameterQuotationItem::query()
            ->join('quotation_items', 'parameter_quotation_items.quotation_item_id', '=', 'quotation_items.id')
            ->join('quotations', 'quotation_items.quotation_id', '=', 'quotations.id')
            ->where('quotations.status', QuotationStatusEnum::Accepted->value)
            ->select('parameter_quotation_items.parameter_id', DB::raw('count(parameter_quotation_items.id) as total_requests'))
            ->groupBy('parameter_quotation_items.parameter_id')
            ->orderByDesc('total_requests')
            ->limit(5)
            ->with('parameter'); // Eager load relasi ke model Parameter untuk mendapatkan nama
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('parameter.name')
                ->label('Nama Parameter')
                ->sortable()
                ->searchable(),
            TextColumn::make('total_requests')
                ->label('Jumlah Permintaan')
                ->sortable()
                ->alignEnd(),
        ];
    }

    public function getTableRecordKey(Model $record): string
    {
        return (string) $record->parameter_id;
    }

    protected function getTableHeading(): ?string
    {
        return 'Top 5 Parameter Paling Sering Diminta (Penawaran Diterima)';
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5];
    }
}
