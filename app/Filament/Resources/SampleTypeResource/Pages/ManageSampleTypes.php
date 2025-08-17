<?php

namespace App\Filament\Resources\SampleTypeResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\SampleTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSampleTypes extends ManageRecords
{
    protected static string $resource = SampleTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
