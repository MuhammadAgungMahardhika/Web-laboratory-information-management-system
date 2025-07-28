<?php

namespace App\Filament\Resources\TermTemplateResource\Pages;

use App\Filament\Resources\TermTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTermTemplate extends ViewRecord
{
    protected static string $resource = TermTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
