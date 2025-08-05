<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use App\Filament\Resources\LabJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLabJob extends ViewRecord
{
    protected static string $resource = LabJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
