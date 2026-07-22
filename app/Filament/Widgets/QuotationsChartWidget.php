<?php

namespace App\Filament\Widgets;

use App\Models\Enums\QuotationStatusEnum;
use Filament\Widgets\ChartWidget;
use App\Models\Quotation;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationsChartWidget extends ChartWidget
{
    use HasFiltersSchema;
    protected static bool $isLazy = false;
    protected bool $isCollapsible = true;
    protected ?string $heading = 'Status Penawaran';
    protected ?string $pollingInterval = null;
    public const PERMISSION_VIEW_CHART_QUOTATION = 'view-chart-quotation';


    public static function canView(): bool
    {
        return Auth::user()->can(static::PERMISSION_VIEW_CHART_QUOTATION);
    }
    protected function getType(): string
    {
        return 'bar'; // Menggunakan chart donat untuk proporsi
    }

    protected function getData(): array
    {
        // 1. Ambil data status dari tabel quotations
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        $query = Quotation::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status');

        // Tambahkan filter tanggal jika ada
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }

        $statusCounts = $query->get();

        // 2. Siapkan array kosong untuk labels, data, dan warna
        $labels = [];
        $data = [];
        $colors = [];

        // 3. Loop melalui data untuk mengisi array
        foreach (QuotationStatusEnum::cases() as $status) {
            $count = $statusCounts->firstWhere('status', $status->value)?->total ?? 0;

            $labels[] = strtoupper($status->label()); // Ambil label yang sudah diformat dari Enum
            $data[] = $count;
            $colors[] = QuotationStatusEnum::cssColor($status->value); // Ambil warna CSS dari Enum
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Penawaran',
                    'data' => $data,
                    'backgroundColor' => $colors, // Gunakan array warna yang sudah disiapkan
                ],
            ],
        ];
    }

    public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('startDate')
                ->label('Tanggal Mulai')
                ->default(now()->subYear())
                ->maxDate(now()),
            DatePicker::make('endDate')
                ->label('Tanggal Akhir')
                ->default(now())
                ->maxDate(now())
                ->afterOrEqual('startDate'),
        ]);
    }
}
