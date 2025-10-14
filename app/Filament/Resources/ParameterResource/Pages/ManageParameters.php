<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use App\Filament\Exports\ParameterExporter;
use Filament\Actions\CreateAction;
use App\Filament\Resources\ParameterResource;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageParameters extends ManageRecords
{
    protected static string $resource = ParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
            ExportAction::make('export')->exporter(ParameterExporter::class)
        ];
    }
}
