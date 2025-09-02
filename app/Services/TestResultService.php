<?php

namespace App\Services;

use App\Models\Enums\TestResultStatusEnum;
use App\Models\LabJob;
use App\Models\TestResult;
use Error;
use Exception;
use Illuminate\Support\Facades\Auth;

class TestResultService
{
    /**
     * Membuat semua record TestResult kosong untuk sebuah LabJob.
     * @param LabJob $labJob
     */
    public function generateTestResultsFromLabJob(LabJob $labJob): void
    {
        // 1. Muat semua relasi yang diperlukan
        $labJob->load(['samples.labJobItem.parameterLabJobItems.parameter']);

        foreach ($labJob->samples as $sample) {
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
    }
    // app/Services/TestResultService.php
    public function updateTestResultStatus(TestResult $testResult, TestResultStatusEnum $newStatus): bool
    {
        if ($newStatus === TestResultStatusEnum::RequestValidate) {
            if ($testResult->status === TestResultStatusEnum::Raw->value) {
                $testResult->tested_value ?? throw new Exception('Validasi gagal');
                $testResult->analyst_personel_id = Auth::user()->personel->id;
            } else {
                throw new Exception('Validasi gagal');
            }
        }

        if ($newStatus === TestResultStatusEnum::Validated) {
            if ($testResult->status === TestResultStatusEnum::RequestValidate->value) {
                $testResult->validation_date = now();
                $testResult->validator_personel_id = Auth::user()->personel->id;
            } else {
                throw new Exception('Validasi gagal');
            }
        }
        // Perbarui status penawaran
        $testResult->status = $newStatus->value;
        // Simpan perubahan ke database
        return $testResult->save();
    }

    public function validateAndSetConclusion(TestResult $testResult): TestResult
    {
        // Cek jika hasil sudah diverifikasi
        if ($testResult->validation_status === TestResultStatusEnum::Validated->value) {

            $testedValue = $testResult->tested_value;
            $standardMin = $testResult->standard_value_ref_min; // Ambil nilai dari kolom yang baru
            $standardMax = $testResult->standard_value_ref_max; // Ambil nilai dari kolom yang baru

            // Lakukan perbandingan
            if ($standardMin !== null && $testedValue < $standardMin) {
                $testResult->conclusion_status = 'Not In Accordance';
            } elseif ($standardMax !== null && $testedValue > $standardMax) {
                $testResult->conclusion_status = 'Not In Accordance';
            } elseif ($standardMin === null && $standardMax === null) {
                $testResult->conclusion_status = 'Not Applicable';
            } else {
                $testResult->conclusion_status = 'In Accordance';
            }

            $testResult->save();
        }
        return $testResult;
    }
}
