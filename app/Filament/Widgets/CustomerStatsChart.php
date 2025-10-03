<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CustomerType; // Pastikan model CustomerType diimpor
use App\Models\Customer; // Pastikan model Customer diimpor
use Illuminate\Support\Facades\Auth;

class CustomerStatsChart extends ChartWidget
{

    protected ?string $heading = 'Pelanggan by Tipe';
    protected ?string $pollingInterval = null;
    public const PERMISSION_VIEW_CHART_CUSTOMER = 'view-chart-customer';
    public static function canView(): bool
    {
        return Auth::user()->can(static::PERMISSION_VIEW_CHART_CUSTOMER);
    }
    protected function getType(): string
    {
        return 'doughnut'; // Menggunakan chart donat
    }

    protected function getData(): array
    {
        // 1. Ambil semua jenis pelanggan yang aktif
        $customerTypes = CustomerType::query()->pluck('name', 'id');

        // 2. Siapkan array kosong untuk label dan data
        $labels = [];
        $data = [];

        // 3. Loop melalui setiap jenis pelanggan untuk menghitung jumlahnya
        foreach ($customerTypes as $id => $name) {
            $labels[] = $name;
            // Hitung jumlah pelanggan yang memiliki customer_type_id ini
            $data[] = Customer::where('customer_type_id', $id)->count();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pelanggan',
                    'data' => $data,
                    // Tambahkan warna dinamis jika diinginkan
                    'backgroundColor' => [
                        '#FF6384', // Merah
                        '#36A2EB', // Biru
                        '#FFCE56', // Kuning
                        '#4BC0C0', // Hijau
                        '#9966FF', // Ungu
                        '#FF9F40', // Oranye
                    ],
                ],
            ],
        ];
    }
}
