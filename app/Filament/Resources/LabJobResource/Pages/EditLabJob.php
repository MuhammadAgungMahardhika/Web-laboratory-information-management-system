<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use App\Filament\Resources\LabJobResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabJob extends EditRecord
{
    protected static string $resource = LabJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
