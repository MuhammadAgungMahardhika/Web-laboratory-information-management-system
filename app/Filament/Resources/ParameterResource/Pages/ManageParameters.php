<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use App\Filament\Exports\ParameterExporter;
use App\Filament\Imports\ParameterImporter;
use Filament\Actions\CreateAction;
use App\Filament\Resources\ParameterResource;
use App\Models\Enums\ParameterStatusEnum;
use App\Models\Parameter;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ManageParameters extends ManageRecords
{
    protected static string $resource = ParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
            ImportAction::make('import')->importer(ParameterImporter::class)->icon(Heroicon::ArrowDown)->slideOver()->authorize(fn() => Auth::user()->can('import-parameter')),
            ExportAction::make('export')->exporter(ParameterExporter::class)->icon(Heroicon::ArrowUp)->slideOver()->authorize(fn() => Auth::user()->can('export-parameter'))
        ];
    }

    public function getTabs(): array
    {
        $counts = Parameter::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $tabs = [
            'all' => Tab::make('Semua')
                ->badge($counts->sum())
                ->badgeColor('gray'),
        ];

        foreach (ParameterStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->label())
                ->badge($counts[$status->value] ?? 0)
                ->badgeColor(ParameterStatusEnum::color($status->value))
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('status', $status->value)
                );
        }

        return $tabs;
    }
}
