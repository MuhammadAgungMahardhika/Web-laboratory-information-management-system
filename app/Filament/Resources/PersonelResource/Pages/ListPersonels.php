<?php

namespace App\Filament\Resources\PersonelResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\PersonelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPersonels extends ListRecords
{
    protected static string $resource = PersonelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
        ];
    }
}
