<?php

namespace App\Services;

use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\LabJob;
use App\Models\LabJobItem;
use App\Models\ParameterLabJobItem;
use App\Models\Quotation;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class LabJobService
{

    public function generateLabJobNumber(): string
    {
        $currentYear = Carbon::now()->format('y'); // 25
        $currentMonth = Carbon::now()->format('m'); // 08

        $totalJobsThisMonth = LabJob::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Format nomor unik dengan padding
        $uniqueNumber = str_pad($totalJobsThisMonth + 1, 4, '0', STR_PAD_LEFT);

        return "LAB-JLI-{$currentYear}{$currentMonth}{$uniqueNumber}";
    }

    public function createLabJobFromQuotation(Quotation $quotation): LabJob
    {
        // Contoh logika untuk membuat LabJob
        $labJob = LabJob::create([
            'quotation_id' => $quotation->id,
            'job_number' => $this->generateLabJobNumber(),
            'status' => JobStatusEnum::PendingStart->value, // Menggunakan kolom yang benar
        ]);
        // 2. Salin rincian item penawaran (snapshot) ke rincian pekerjaan lab
        $quotation->load(['quotationItems' => fn($query) => $query->where('group', 'A'), 'quotationItems.parameterQuotationItems']);

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

            // 3. Salin rincian parameter (snapshot) (Paket Pengujian)
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

        Log::info("Lab Job #{$labJob->job_number} and its items created from Quotation #{$quotation->quotation_number}.");
        return $labJob;
    }

    /**
     * Menghapus semua item pekerjaan lab dan menyalin ulang dari penawaran.
     *
     * @param LabJob $labJob
     * @return void
     */
    public function resetToQuotationSnapshot(LabJob $labJob): LabJob
    {

        // 1. Hapus semua item pekerjaan lab dan parameternya
        $labJob->labJobItems->each(function ($item) {
            $item->parameterLabJobItems()->delete();
        });
        // Hapus item pekerjaan lab itu sendiri 
        $labJob->labJobItems()->delete();

        // 2. Muat penawaran induk dan itemnya
        $labJob->load(['quotation.quotationItems' => fn($query) => $query->where('group', 'A'), 'quotation.quotationItems.parameterQuotationItems']);
        $quotation = $labJob->quotation;

        if ($quotation) {
            // 3. Salin ulang item dari penawaran
            foreach ($quotation->quotationItems as $quotationItem) {
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

                // Salin ulang parameter snapshot
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
        Log::info("Lab Job #{$labJob->job_number} have been reset from Quotation #{$quotation->quotation_number}.");
        return $labJob;
    }
    /**
     * Mengubah status penawaran dan memicu aksi terkait.
     *
     * @param LabJob $labJob
     * @param JobStatusEnum $newStatus
     * @return bool
     */
    public function updateLabJobStatus(LabJob $labJob, JobStatusEnum $newStatus, array $data = null): bool
    {
        // Perbarui status penawaran

        // mulai job
        if ($newStatus === JobStatusEnum::InProgress) {
            $labJob->start_date = $data['start_date'] ?? $labJob->start_date;
            $labJob->end_date = $data['end_date'] ?? $labJob->end_date;
            $labJob->status = $newStatus->value;
            $isSuccessed =   $labJob->save();
        }
        // selesai sampling
        if ($newStatus === JobStatusEnum::SamplingCompleted) {
            // Cek apakah semua samples memiliki status Received atau Invalid
            $hasInvalidStatusSamples = $labJob->samples
                ->whereNotIn('status', [
                    SampleStatusEnum::Received->value,
                    SampleStatusEnum::Invalid->value
                ])
                ->isNotEmpty();

            if ($hasInvalidStatusSamples) {
                throw new Exception("Tidak bisa mengubah status ke Sampling Completed. Masih ada sampel dengan status selain 'Diterima' atau 'Tidak Valid'.");
            }
            $labJob->status = $newStatus->value;
            $isSuccessed =  $labJob->save();
        }

        // selesai analisis
        if ($newStatus === JobStatusEnum::AnalysisCompleted) {
            $hasUnvalidatedSamples = $labJob->samples
                ->whereNotIn('status',  [SampleStatusEnum::AnalysisCompleted->value, SampleStatusEnum::Invalid->value])
                ->isNotEmpty();

            if ($hasUnvalidatedSamples) {
                throw new Exception("Masih ada sampel yang belum tervalidasi.");
            }
            $labJob->status = $newStatus->value;
            $isSuccessed =   $labJob->save();
        }
        // job selesai / dikirim
        if ($newStatus === JobStatusEnum::Delivered) {
            $labJob->end_date = now();
            $labJob->status = $newStatus->value;
            $isSuccessed =  $labJob->save();
        }
        // Simpan perubahan ke database
        return $isSuccessed;
    }
}
