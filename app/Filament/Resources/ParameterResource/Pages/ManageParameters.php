<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ParameterResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageParameters extends ManageRecords
{
    protected static string $resource = ParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
