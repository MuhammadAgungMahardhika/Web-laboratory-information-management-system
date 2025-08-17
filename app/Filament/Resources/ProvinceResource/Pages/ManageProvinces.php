<?php

namespace App\Filament\Resources\ProvinceResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ProvinceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProvinces extends ManageRecords
{
    protected static string $resource = ProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
