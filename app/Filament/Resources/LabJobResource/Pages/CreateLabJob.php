<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use App\Filament\Resources\LabJobResource;
use App\Models\Quotation;
use App\Services\LabJobService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Log;
use Filament\Notifications\Notification;

class CreateLabJob extends CreateRecord
{
    protected static string $resource = LabJobResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        try {
            return DB::transaction(function () use ($data) {
                $quotation = Quotation::find($data['quotation_id']);
                $labJobService = new LabJobService();
                $labJob = $labJobService->createLabJobFromQuotation($quotation);
                return $labJob;
            });
        } catch (\Exception $e) {
            Log::error('Error creating LabJob: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $data,
            ]);
            throw $e;
        }
    }
}
