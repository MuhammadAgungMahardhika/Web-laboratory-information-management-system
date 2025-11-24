<?php

namespace App\Filament\Resources\TestMethodResource\Pages;

use App\Filament\Exports\TestMethodExporter;
use App\Filament\Imports\TestMethodImporter;
use Filament\Actions\CreateAction;
use App\Filament\Resources\TestMethodResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

class ManageTestMethods extends ManageRecords
{
    protected static string $resource = TestMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
            ImportAction::make('import')->importer(TestMethodImporter::class)->icon(Heroicon::ArrowDown)->slideOver(),
            ExportAction::make('export')->exporter(TestMethodExporter::class)->icon(Heroicon::ArrowUp)->slideOver()
        ];
    }
}
