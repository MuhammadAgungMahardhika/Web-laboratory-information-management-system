<?php

namespace App\Services;

use App\Models\Sample;
use App\Models\LabJobItem; // Import model LabJobItem
use Illuminate\Support\Str;

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
        // Pastikan relasi labJob dimuat
        $labJobItem->load('labJob');

        // Ambil nomor pekerjaan lab
        $jobNumber = $labJobItem->labJob->job_number;

        // Hitung jumlah sampel yang sudah ada untuk item pekerjaan ini
        $sampleCount = Sample::where('lab_job_item_id', $labJobItem->id)->count();

        // Format nomor urut sampel
        $sampleNumber = str_pad($sampleCount + 1, 2, '0', STR_PAD_LEFT);

        // Gabungkan menjadi format akhir (misal: JOB-001-01)
        return "{$jobNumber}-{$sampleNumber}";
    }

    /**
     * Membuat record sampel baru dengan kode sampel yang digenerate otomatis.
     *
     * @param LabJobItem $labJobItem
     * @param array $data
     * @return Sample
     */
    public function createSample(LabJobItem $labJobItem, array $data): Sample
    {
        $sampleCode = $this->generateSampleCode($labJobItem);
        $data['sample_code'] = $sampleCode;
        $data['lab_job_item_id'] = $labJobItem->id;

        return Sample::create($data);
    }
}
