<?php

namespace App\Filament\Widgets;

use App\Models\Enums\QuotationStatusEnum;
use Filament\Widgets\ChartWidget;
use App\Models\Quotation;
use Illuminate\Support\Facades\DB;

class QuotationStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Perbandingan Penawaran Berdasarkan Status';

    protected function getType(): string
    {
        return 'doughnut'; // Menggunakan chart donat untuk proporsi
    }

    protected function getData(): array
    {
        // 1. Ambil data status dari tabel quotations
        $statusCounts = Quotation::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

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
}