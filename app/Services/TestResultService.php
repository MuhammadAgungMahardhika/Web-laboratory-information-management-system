<?php

namespace App\Services;

use App\Models\Enums\SampleStatusEnum;
use App\Models\Enums\TestResultApprovalStatusEnum;
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
        // Hindari duplicate jika method terpanggil dua kali
        if ($sample->testResults()->exists()) {
            return;
        }
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

    /**
     * Re-open hasil uji.
     * Dipanggil ketika Sample dari Analysis Completed kembali ke Prepared.
     */
    public function reopenTestResultsFromSample(Sample $sample): void
    {
        $sample->load('testResults.testResultApprovals');

        foreach ($sample->testResults as $testResult) {

            // Approval lama tetap disimpan sebagai histori
            $testResult->testResultApprovals()
                ->whereIn('status', [
                    TestResultApprovalStatusEnum::Pending->value,
                    TestResultApprovalStatusEnum::Accepted->value,
                    TestResultApprovalStatusEnum::Revision->value,
                ])
                ->update([
                    'status' => TestResultApprovalStatusEnum::Revoked->value,
                    'updated_by' => Auth::user()?->name,

                ]);

            // Test Result kembali menjadi revisi
            $testResult->update([
                'status' => TestResultStatusEnum::RevisionNeeded->value,
                'validator_personel_id' => null,
                'validation_date' => null,
                'updated_by' => Auth::user()?->name,
            ]);

            // tested_value tidak dihapus
            // evaluation_status tidak dihapus
            // test_notes tidak dihapus
            // comment tetap disimpan
            // revision_count juga tetap
        }
    }
}
