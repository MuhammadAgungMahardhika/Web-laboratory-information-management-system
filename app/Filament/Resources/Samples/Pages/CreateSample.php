<?php

namespace App\Filament\Resources\Samples\Pages;

use App\Filament\Resources\Samples\SampleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSample extends CreateRecord
{
    protected static string $resource = SampleResource::class;
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'lab_job_item_id' => request('lab_job_item_id'),
        ]);
    }
}
