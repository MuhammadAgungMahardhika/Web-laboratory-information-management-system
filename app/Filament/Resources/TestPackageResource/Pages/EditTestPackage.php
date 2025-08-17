<?php

namespace App\Filament\Resources\TestPackageResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\TestPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestPackage extends EditRecord
{
    protected static string $resource = TestPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
