<?php

namespace App\Services;

use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJobItem; // Import model LabJobItem
use App\Models\Sample;
use Exception;

class SampleService
{
    /**
     * Menghasilkan kode sampel yang unik berdasarkan item pekerjaan lab.
     *
     * @param LabJobItem $labJobItem
     * @return string
     */
    public function generateSampleCode(LabJobItem $labJobItem): string
    {
        $labJobItem->load('labJob');
        $jobNumber = $labJobItem->labJob->job_number;
        $sampleCount = $labJobItem->labJob->samples()->count();
        $sampleNumber = $sampleCount + 1;
        return "{$jobNumber}-{$sampleNumber}";
    }

    public function updateSampleStatus(Sample $sample, SampleStatusEnum $newStatus): bool
    {
        if ($newStatus === SampleStatusEnum::Prepared) {
            if ($sample->status === SampleStatusEnum::Received->value) {
                $testResultService = new TestResultService();
                $testResultService->generateTestResultsFromSample($sample);
            } else {
                throw new Exception('Validasi gagal');
            }
        }
        // Perbarui status penawaran
        $sample->status = $newStatus->value;
        // Simpan perubahan ke database
        return $sample->save();
    }
}
