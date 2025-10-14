<?php

namespace App\Filament\Resources\TestPackageResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\TestPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Size;

class ListTestPackages extends ListRecords
{
    protected static string $resource = TestPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver()->size(Size::ExtraLarge),
        ];
    }
}
