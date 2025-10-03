<?php

namespace App\Filament\Widgets;

use App\Models\Enums\SampleStatusEnum;
use App\Models\Sample;
use DB;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;
use Illuminate\Support\Facades\Auth;

class SamplesChartWidget extends ChartWidget
{
    use HasFiltersSchema;
    protected static bool $isLazy = false;
    protected bool $isCollapsible = true;

    protected ?string $heading = 'Sampel by Status';
    protected ?string $pollingInterval = null;
    public const PERMISSION_VIEW_CHART_SAMPLE = 'view-chart-test-sample';

    public static function canView(): bool
    {
        // return Auth::user()->can(static::PERMISSION_VIEW_CHART_TEST_RESULT);
        return true;
    }
    protected function getData(): array
    {
        // 1. Ambil data status dari tabel quotations
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        $query = Sample::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status');

        // Tambahkan filter tanggal jika ada
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $statusCounts = $query->get();

        // 2. Siapkan array kosong untuk labels, data, dan warna
        $labels = [];
        $data = [];
        $colors = [];

        // 3. Loop melalui data untuk mengisi array
        foreach (SampleStatusEnum::cases() as $status) {
            $count = $statusCounts->firstWhere('status', $status->value)?->total ?? 0;

            $labels[] = strtoupper($status->label()); // Ambil label yang sudah diformat dari Enum
            $data[] = $count;
            $colors[] = SampleStatusEnum::cssColor($status->value); // Ambil warna CSS dari Enum
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Hasil Pengujian',
                    'data' => $data,
                    'backgroundColor' => $colors, // Gunakan array warna yang sudah disiapkan
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('startDate')
                ->label('Tanggal Mulai')
                ->default(now()->subDays(30))
                ->maxDate(now()),
            DatePicker::make('endDate')
                ->label('Tanggal Akhir')
                ->default(now())
                ->maxDate(now())
                ->afterOrEqual('startDate'),
        ]);
    }
}
