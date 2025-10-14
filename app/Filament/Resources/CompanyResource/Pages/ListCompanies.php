<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Size;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver()->size(Size::ExtraLarge),
        ];
    }
}
