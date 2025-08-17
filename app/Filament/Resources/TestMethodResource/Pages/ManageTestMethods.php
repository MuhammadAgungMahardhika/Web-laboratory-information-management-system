<?php

namespace App\Filament\Resources\TestMethodResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\TestMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTestMethods extends ManageRecords
{
    protected static string $resource = TestMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
