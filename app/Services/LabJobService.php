<?php

namespace App\Services;

use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\QuotationStatusEnum;
use App\Models\LabJob;
use App\Models\LabJobItem;
use App\Models\ParameterLabJobItem;
use App\Models\Quotation;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LabJobService
{
    public function generateLabJobNumber(Quotation $quotation): string
    {
        // Gabungkan menjadi format akhir
        return "JOB-{$quotation->quotation_number}";
    }

    public function createLabJobFromQuotation(Quotation $quotation): LabJob
    {
        // Contoh logika untuk membuat LabJob
        $labJob = LabJob::create([
            'quotation_id' => $quotation->id,
            'job_number' => $this->generateLabJobNumber($quotation),
            'start_date' => now(),
            'status' => JobStatusEnum::PendingStart->value, // Menggunakan kolom yang benar
        ]);
        // 2. Salin rincian item penawaran (snapshot) ke rincian pekerjaan lab
        $quotation->load('quotationItems.parameterQuotationItems'); // Eager load relasi

        foreach ($quotation->quotationItems as $quotationItem) {
            // Buat item pekerjaan lab baru sebagai snapshot
            $labJobItem = LabJobItem::create([
                'lab_job_id' => $labJob->id,
                'quotation_item_id' => $quotationItem->id,
                'test_package_id' => $quotationItem->test_package_id,
                'regulation_id' => $quotationItem->regulation_id,
                'group' => $quotationItem->group,
                'description' => $quotationItem->description,
                'regulation_name' => $quotationItem->regulation_name,
                'quantity' => $quotationItem->quantity,
                'unit' => $quotationItem->unit,
                'price' => $quotationItem->price,
                'location' => $quotationItem->location,
            ]);

            // 3. Salin rincian parameter (snapshot) jika grupnya 'A' (Paket Pengujian)
            if ($quotationItem->group === 'A') {
                foreach ($quotationItem->parameterQuotationItems as $paramSnapshot) {
                    ParameterLabJobItem::create([
                        'lab_job_item_id' => $labJobItem->id,
                        'parameter_id' => $paramSnapshot->parameter_id,
                        'parameter_name' => $paramSnapshot->parameter_name,
                        'parameter_unit' => $paramSnapshot->parameter_unit,
                        'parameter_default_price' => $paramSnapshot->parameter_default_price,
                        'parameter_default_test_method_name' => $paramSnapshot->parameter_default_test_method_name,
                        'parameter_description' => $paramSnapshot->parameter_description,
                        'parameter_status' => $paramSnapshot->parameter_status,
                    ]);
                }
            }
        }

        Log::info("Lab Job #{$labJob->job_number} and its items created from Quotation #{$quotation->quotation_number}.");
        return $labJob;
    }

    /**
     * Mengubah status penawaran dan memicu aksi terkait.
     *
     * @param LabJob $labJob
     * @param JobStatusEnum $newStatus
     * @return bool
     */
    public function updateLabJobStatus(LabJob $labJob, JobStatusEnum $newStatus): bool
    {
        // 1. Perbarui status penawaran
        $labJob->status = $newStatus->value;

        // 3. Simpan perubahan ke database
        return $labJob->save();
    }
}
