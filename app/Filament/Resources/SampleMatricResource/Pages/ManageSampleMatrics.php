<?php

namespace App\Filament\Resources\SampleMatricResource\Pages;

use App\Filament\Resources\SampleMatricResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSampleMatrics extends ManageRecords
{
    protected static string $resource = SampleMatricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
