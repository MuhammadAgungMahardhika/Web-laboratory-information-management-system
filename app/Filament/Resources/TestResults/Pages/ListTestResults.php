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
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA'),
        ];

        foreach (TestResultStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->value)
                ->badge(TestResult::query()->where('status', $status->value)->count())
                ->badgeColor(TestResultStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
