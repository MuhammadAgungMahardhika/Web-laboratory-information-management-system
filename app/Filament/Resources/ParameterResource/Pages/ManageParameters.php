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

class ManageParameters extends ManageRecords
{
    protected static string $resource = ParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
            ImportAction::make('import')->importer(ParameterImporter::class)->icon(Heroicon::ArrowDown)->slideOver(),
            ExportAction::make('export')->exporter(ParameterExporter::class)->icon(Heroicon::ArrowUp)->slideOver()
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge(Parameter::count())
                ->badgeColor('gray'),

            'accredited' => Tab::make('Terakreditasi')
                ->badge(Parameter::where('status', ParameterStatusEnum::Accredited->value)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', ParameterStatusEnum::Accredited->value)),

            'unaccredited' => Tab::make('Tidak Terakreditasi')
                ->badge(Parameter::where('status', ParameterStatusEnum::Unaccredited->value)->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', ParameterStatusEnum::Unaccredited->value)),

            'sub' => Tab::make('Sub-kontrak')
                ->badge(Parameter::where('status', ParameterStatusEnum::Sub->value)->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', ParameterStatusEnum::Sub->value)),
        ];
    }
}
