<?php

namespace App\Filament\Resources\RegulationTypes\Pages;

use App\Filament\Resources\RegulationTypes\RegulationTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRegulationType extends ViewRecord
{
    protected static string $resource = RegulationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
