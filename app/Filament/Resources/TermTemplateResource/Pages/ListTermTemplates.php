<?php

namespace App\Filament\Resources\TermTemplateResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\TermTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTermTemplates extends ListRecords
{
    protected static string $resource = TermTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
