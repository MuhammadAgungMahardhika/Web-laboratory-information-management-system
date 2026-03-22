<?php

namespace App\Filament\Resources\Params\Pages;

use App\Filament\Resources\Params\ParamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageParams extends ManageRecords
{
    protected static string $resource = ParamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
