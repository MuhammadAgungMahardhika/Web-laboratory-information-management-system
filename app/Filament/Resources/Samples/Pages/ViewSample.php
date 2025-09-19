<?php

namespace App\Filament\Resources\Samples\Pages;

use App\Filament\Resources\Samples\Actions\SampleAction;
use App\Filament\Resources\Samples\SampleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSample extends ViewRecord
{
    protected static string $resource = SampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SampleAction::downloadLabel(),
            EditAction::make(),
        ];
    }
}
