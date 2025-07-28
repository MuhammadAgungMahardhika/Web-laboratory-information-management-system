<?php

namespace App\Filament\Resources\TermTemplateResource\Pages;

use App\Filament\Resources\TermTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTermTemplate extends EditRecord
{
    protected static string $resource = TermTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
