<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\LabJob;
use App\Services\InvoiceService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
    protected function handleRecordCreation(array $data): Model
    {
        $labJob = LabJob::findOrFail(
            $data['lab_job_id']
        );

        return app(InvoiceService::class)
            ->createInvoiceFromLabJob(
                $labJob,
                $data
            );
    }
}
