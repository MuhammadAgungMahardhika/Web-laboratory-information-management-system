<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User; // Pastikan model User diimpor
use Illuminate\Support\Facades\DB;

class PersonnelRolesChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Personil Berdasarkan Peran';

    protected function getType(): string
    {
        return 'bar'; // Menggunakan bar chart untuk perbandingan
    }

    protected function getData(): array
    {
        // 1. Ambil data peran menggunakan tabel Spatie Laravel Permission
        $rolesData = User::query()
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('count(users.id) as total_users'))
            ->where('model_has_roles.model_type', User::class) // Penting: Hanya ambil peran untuk model User
            ->groupBy('roles.name')
            ->get();

        // 2. Siapkan array untuk labels dan data chart
        $labels = $rolesData->pluck('name')->toArray(); // Ambil nama peran sebagai label
        $data = $rolesData->pluck('total_users')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Personil',
                    'data' => $data,
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                    ],
                    'borderColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                    ],
                    'borderWidth' => 1,
                ],
            ],
        ];
    }
}