<?php

namespace App\Filament\Resources\TestResults\Pages;

use App\Filament\Resources\TestResults\TestResultResource;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTestResults extends ListRecords
{
    protected static string $resource = TestResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA')
                ->badge(TestResult::count()),
        ];

        // ambil jumlah per status dalam 1 query
        $counts = TestResult::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        foreach (TestResultStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->value)
                ->badge($counts[$status->value] ?? 0)
                ->badgeColor(TestResultStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
