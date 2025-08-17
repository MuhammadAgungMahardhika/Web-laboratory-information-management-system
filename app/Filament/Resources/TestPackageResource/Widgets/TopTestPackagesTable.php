<?php

namespace App\Filament\Resources\TestPackageResource\Widgets;

use App\Models\Enums\QuotationStatusEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\QuotationItem;
use Illuminate\Database\Eloquent\Model;

class TopTestPackagesTable extends TableWidget
{
    protected static ?string $heading = '5 Paket Pengujian Terpopuler';
    // protected static ?int $sort = 2; // Atur urutan setelah widget pertama
    protected int | string | array $columnSpan = ['xl' => 3,  'md' => 2, 'sm' => 1,'lg' => 3];
    protected static ?string $pollingInterval = null;
    protected function getTableQuery(): Builder
    {
        return QuotationItem::query()
            ->join('quotations', 'quotation_items.quotation_id', '=', 'quotations.id')
            ->where('quotations.status', QuotationStatusEnum::Accepted->value)
            ->select('quotation_items.test_package_id', DB::raw('count(quotation_items.id) as total_requests'))
            ->groupBy('quotation_items.test_package_id')
            ->orderByDesc('total_requests')
            ->limit(5)
            ->with('testPackage'); // Eager load relasi ke TestPackage untuk mendapatkan nama
    }

    public function getTableRecordKey(Model|array $record): string
    {
        return (string) $record->test_package_id;
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('testPackage.name')
                ->label('Nama Paket Pengujian')
                ->sortable()
                ->searchable(),
            TextColumn::make('total_requests')
                ->label('Jumlah Permintaan')
                ->sortable()
                ->alignEnd(),
        ];
    }


    protected function getTableHeading(): ?string
    {
        return 'Top 5 Paket Pengujian Terpopuler';
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5]; // Hanya tampilkan 5 baris
    }
}
