<?php

namespace App\Filament\Resources\TermTemplateResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\TermTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTermTemplate extends EditRecord
{
    protected static string $resource = TermTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
