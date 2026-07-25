<?php

namespace App\Services;

use App\Models\Enums\SampleStatusEnum;
use App\Models\Enums\TestResultEvaluationStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\LabJob;
use App\Models\Sample;
use App\Models\TestResult;
use Error;
use Exception;
use Illuminate\Support\Facades\Auth;

class TestResultService
{
    /**
     * Rollback untuk sebuah sampel.
     * @param Sample $sample
     */
    public function rollBackTestResultsFromSample(Sample $sample): void
    {
        TestResult::where('sample_id', $sample->id)->delete();
    }
    /**
     * Membuat semua record TestResult kosong untuk sebuah sampel.
     * @param Sample $sample
     */

    public function generateTestResultsFromSample(Sample $sample): void
    {
        $this->rollBackTestResultsFromSample($sample);
        $sample->load('labJobItem.parameterLabJobItems.parameter');
        foreach ($sample->labJobItem->parameterLabJobItems as $paramSnapshot) {
            // 2. Buat record TestResult baru untuk setiap pasangan Sample-Parameter
            TestResult::create([
                'sample_id' => $sample->id,
                'parameter_id' => $paramSnapshot->parameter_id,
                'test_method_id' => $paramSnapshot->parameter->test_method_id,
                'unit' => $paramSnapshot->parameter_unit,
                'tested_value' => null, // Nilai masih kosong
                'analyst_personel_id' => null, // Nanti ditugaskan
                'status' => TestResultStatusEnum::Raw->value, // Status awal
                // --- SALIN NILAI STANDAR DI SINI ---
                'standard_notes_ref' =>  $paramSnapshot->parameter->standard_notes,
            ]);
        }
    }
}
