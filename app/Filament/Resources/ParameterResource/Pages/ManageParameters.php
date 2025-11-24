<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use App\Filament\Exports\ParameterExporter;
use App\Filament\Imports\ParameterImporter;
use Filament\Actions\CreateAction;
use App\Filament\Resources\ParameterResource;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

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
}
