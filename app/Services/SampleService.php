<?php

namespace App\Services;

use App\Models\Enums\JobStatusEnum;
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
        if ($newStatus === SampleStatusEnum::Received) {
            $testResultService = new TestResultService();
            $testResultService->rollBackTestResultsFromSample($sample);
        }
        if ($newStatus === SampleStatusEnum::Prepared) {
            if ($sample->status !== SampleStatusEnum::Received->value) {
                throw new Exception("Status belum diterima, update status sampel diterima untuk mengubah status");
            }
            if ($sample->labJobItem->labJob->status !== JobStatusEnum::SamplingCompleted->value) {
                throw new Exception("Status job belum complete, update status job untuk update sampel");
            }
            $testResultService = new TestResultService();
            $testResultService->generateTestResultsFromSample($sample);
        }

        $sample->status = $newStatus->value;
        return $sample->save();
    }
}
