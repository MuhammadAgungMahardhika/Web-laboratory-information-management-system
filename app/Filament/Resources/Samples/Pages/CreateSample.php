<?php

namespace App\Filament\Resources\Samples\Pages;

use App\Filament\Resources\Samples\SampleResource;
use App\Models\Enums\SampleCollectionTypeEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJobItem;
use App\Services\SampleService;
use Filament\Resources\Pages\CreateRecord;

class CreateSample extends CreateRecord
{
    protected static string $resource = SampleResource::class;
    // public function mount(): void
    // {
    //     parent::mount();
    //     if (request('lab_job_item_id')) {
    //         $labJobItem = LabJobItem::find(request('lab_job_item_id'));
    //         $sampleService = app(SampleService::class);
    //         $sampleCode = $sampleService->generateSampleCode($labJobItem);
    //         $this->form->fill([
    //             'lab_job_item_id' => request('lab_job_item_id'),
    //             'code' =>  $sampleCode,
    //             'status' => SampleStatusEnum::default(),
    //             'collection_type' => SampleCollectionTypeEnum::default()
    //         ]);
    //     }
    // }
}
