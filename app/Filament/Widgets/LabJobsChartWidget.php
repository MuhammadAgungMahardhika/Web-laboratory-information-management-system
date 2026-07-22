<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

use App\Models\Enums\JobStatusEnum;
use App\Models\LabJob;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LabJobsChartWidget extends ChartWidget
{
    use HasFiltersSchema;
    protected static bool $isLazy = false;
    protected bool $isCollapsible = true;
    protected ?string $heading = 'Status Pengerjaan Lab Job';
    protected ?string $pollingInterval = null;
    public const PERMISSION_VIEW_CHART_LAB_JOB = 'view-chart-lab-job';
    protected ?string $description = 'Default filter 1 tahun belakang';

    public static function canView(): bool
    {
        return Auth::user()->can(static::PERMISSION_VIEW_CHART_LAB_JOB);
    }
    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        // 1. Ambil data status dari tabel lab_jobs
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        $query = LabJob::query()
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

        // 3. Loop melalui status untuk mengisi array
        foreach (JobStatusEnum::cases() as $status) {
            $count = $statusCounts->firstWhere('status', $status->value)?->total ?? 0;

            $labels[] = $status->label();
            $data[] = $count;
            $colors[] = JobStatusEnum::cssColor($status->value);
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Jobs',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => array_map(function ($color) {
                        return str_replace('0.8', '1', $color);
                    }, $colors),
                    'borderWidth' => 1,
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

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
