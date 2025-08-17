<?php

namespace App\Filament\Resources\PersonelResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\PersonelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonel extends EditRecord
{
    protected static string $resource = PersonelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
