<?php

namespace App\Filament\Resources\TestPackageResource\Pages;

use App\Filament\Resources\TestPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestPackage extends CreateRecord
{
    protected static string $resource = TestPackageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
