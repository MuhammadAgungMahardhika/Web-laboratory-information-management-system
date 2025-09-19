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
                'standard_max_value_ref' =>  $paramSnapshot->parameter->standard_max_value,
                'standard_min_value_ref' =>  $paramSnapshot->parameter->standard_min_value,
                'standard_unit_ref' =>  $paramSnapshot->parameter->standard_unit,
                'standard_notes_ref' =>  $paramSnapshot->parameter->standard_notes,
            ]);
        }
    }

    // app/Services/TestResultService.php
    public function updateTestResultStatus(TestResult $testResult, TestResultStatusEnum $newStatus): bool
    {
        if ($newStatus === TestResultStatusEnum::Raw) {
            $testResult->tested_value ?? throw new Exception('Hasil test belum terisi');
            $testResult->analyst_personel_id = Auth::user()->personel->id;
            $testResult->status = $newStatus->value;
            return $testResult->save();
        }
        if ($newStatus === TestResultStatusEnum::RequestValidate) {
            if (in_array($testResult->status, [TestResultStatusEnum::Raw->value, TestResultStatusEnum::RevisionNeeded->value])) {
                $testResult->tested_value ?? throw new Exception('Hasil test belum terisi');
                $testResult->analyst_personel_id = Auth::user()->personel->id;
                $testResult->status = $newStatus->value;
                $isSuccessed = $testResult->save();
            } else {
                throw new Exception('Status hasil uji bukan "mentah" ');
            }
        }
        if ($newStatus === TestResultStatusEnum::Validated) {
            if ($testResult->status === TestResultStatusEnum::RequestValidate->value) {
                $testResult->validation_date = now();
                $testResult->validator_personel_id = Auth::user()->personel->id;
                $testResult->status = $newStatus->value;
                $isSuccessed = $testResult->save();
                $allValidated = $testResult->sample->isAllTestResultsValidated();
                if ($allValidated) {
                    $sampleService = new SampleService();
                    $sampleService->updateSampleStatus($testResult->sample, SampleStatusEnum::AnalysisCompleted);
                }
            } else {
                throw new Exception('Status hasil uji bukan "request validasi" ');
            }
        }
        if ($newStatus === TestResultStatusEnum::RevisionNeeded) {
            if ($testResult->status === TestResultStatusEnum::RequestValidate->value) {
                $testResult->validation_date = null;
                $testResult->validator_personel_id = Auth::user()->personel->id;
                $testResult->status = $newStatus->value;
                $testResult->revision_count += 1;
                $isSuccessed = $testResult->save();
            } else {
                throw new Exception('Status hasil uji bukan "request validasi" ');
            }
        }
        if ($newStatus === TestResultStatusEnum::Rejected) {
            if ($testResult->status === TestResultStatusEnum::RequestValidate->value) {
                $testResult->validation_date = null;
                $testResult->validator_personel_id = Auth::user()->personel->id;
                $testResult->status = $newStatus->value;
                $isSuccessed = $testResult->save();
            } else {
                throw new Exception('Status hasil uji bukan "request validasi" ');
            }
        }
        return  $isSuccessed;
    }

    public function evaluateResult(TestResult $testResult, ?float $min = null, ?float $max = null): TestResultEvaluationStatusEnum
    {
        $value = $testResult->tested_value;

        // Tidak ada nilai yang diuji → invalid
        if ($value === null) {
            return TestResultEvaluationStatusEnum::Invalid;
        }

        // Tidak ada standar sama sekali → not applicable
        if ($min === null && $max === null) {
            return TestResultEvaluationStatusEnum::NotApplicable;
        }

        // Ada minimum & maksimum
        if ($min !== null && $max !== null) {
            if ($value < $min) {
                return TestResultEvaluationStatusEnum::BelowStandard;
            }
            if ($value > $max) {
                return TestResultEvaluationStatusEnum::AboveStandard;
            }
            return TestResultEvaluationStatusEnum::Compliant;
        }

        // Hanya ada minimum
        if ($min !== null && $max === null) {
            return $value < $min
                ? TestResultEvaluationStatusEnum::BelowStandard
                : TestResultEvaluationStatusEnum::Compliant;
        }

        // Hanya ada maksimum
        if ($max !== null && $min === null) {
            return $value > $max
                ? TestResultEvaluationStatusEnum::AboveStandard
                : TestResultEvaluationStatusEnum::Compliant;
        }

        // fallback
        return TestResultEvaluationStatusEnum::NotApplicable;
    }

    public function updateEvaluationStatus(TestResult $testResult, ?float $min = null, ?float $max = null): void
    {
        $status = $this->evaluateResult($testResult, $min, $max);
        $testResult->evaluation_status = $status->value;
        $testResult->save();
    }
}
