<?php

namespace App\Filament\Resources\TestResults\Pages;

use App\Filament\Resources\TestResults\TestResultResource;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListTestResults extends ListRecords
{
    protected static string $resource = TestResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make()->slideOver()->modalWidth(Width::SixExtraLarge),
        ];
    }

    public function getTabs(): array
    {
        $baseQuery = TestResult::query()
            ->visibleForUser(Auth::user());

        $counts = (clone $baseQuery)
            ->selectRaw('status, COUNT(*) total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $total = $counts->sum();
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA')
                ->badge($total),
        ];



        foreach (TestResultStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->label())
                ->badge($counts[$status->value] ?? 0)
                ->badgeColor(TestResultStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('status', $status->value)
                );
        }

        return $tabs;
    }
}
