<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\LabJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords; // Pastikan ini diimpor
use Illuminate\Database\Eloquent\Builder; // Pastikan ini diimpor
use App\Models\Enums\JobStatusEnum; // Pastikan ini diimpor
use App\Models\LabJob; // Pastikan ini diimpor

class ListLabJobs extends ListRecords
{
    protected static string $resource = LabJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    // public function getDefaultActiveTab(): string|int|null
    // {
    //     return JobStatusEnum::PendingStart->value; // Menggunakan enum untuk mendapatkan status default
    // }
    public function getTabs(): array
    {
        // Tab "SEMUA"
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA')
                ->badge(LabJob::count()),
        ];

        // Hitung jumlah per status sekali query
        $counts = LabJob::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Buat tab untuk tiap status
        foreach (JobStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->value)
                ->badge($counts[$status->value] ?? 0)
                ->badgeColor(JobStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
