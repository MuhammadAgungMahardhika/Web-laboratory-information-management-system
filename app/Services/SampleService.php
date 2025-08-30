<?php

namespace App\Services;

use App\Models\LabJobItem; // Import model LabJobItem
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
}
