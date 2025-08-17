<?php

namespace App\Filament\Resources\ParameterResource\Widgets;

use App\Models\Enums\ParameterStatusEnum;
use Filament\Widgets\ChartWidget;
use App\Models\Parameter;
use Illuminate\Support\Facades\DB;

class ParameterAccreditationChart extends ChartWidget
{
    protected ?string $heading = 'Perbandingan Parameter Terakreditasi';
    protected ?string $pollingInterval = null;
    protected function getType(): string
    {
        return 'pie'; // Menggunakan pie chart untuk proporsi
    }

    protected function getData(): array
    {
        // 1. Ambil data status dari tabel parameters
        $statusCounts = Parameter::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 2. Siapkan array kosong untuk labels, data, dan warna
        $labels = [];
        $data = [];
        $colors = [];

        // 3. Loop melalui setiap status di Enum untuk mengisi array
        foreach (ParameterStatusEnum::cases() as $status) {
            $count = $statusCounts->firstWhere('status', $status->value)?->total ?? 0;

            $labels[] = strtoupper($status->label()); // Asumsi Enum memiliki metode label()
            $data[] = $count;
            $colors[] = ParameterStatusEnum::cssColor($status->value); // Asumsi Enum memiliki metode cssColor()
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Parameter',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
        ];
    }
}
