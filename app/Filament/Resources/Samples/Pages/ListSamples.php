<?php

namespace App\Filament\Resources\Samples\Pages;

use App\Filament\Resources\Samples\SampleResource;
use App\Models\Enums\SampleStatusEnum;
use App\Models\Sample;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSamples extends ListRecords
{
    protected static string $resource = SampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        // Tab "SEMUA"
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA')
                ->badge(Sample::count()),
        ];

        // Hitung jumlah per status sekali query
        $counts = Sample::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Buat tab untuk tiap status
        foreach (SampleStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->value)
                ->badge($counts[$status->value] ?? 0)
                ->badgeColor(SampleStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
