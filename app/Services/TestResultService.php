<?php

namespace App\Services;

use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use Error;
use Exception;
use Illuminate\Support\Facades\Auth;

class TestResultService
{
    // app/Services/TestResultService.php
    public function updateTestResultStatus(TestResult $testResult, TestResultStatusEnum $newStatus): bool
    {
        if ($newStatus === TestResultStatusEnum::RequestValidate) {
            if ($testResult->status === TestResultStatusEnum::Raw->value) {
                $testResult->tested_value ?? throw new Exception('Validasi gagal');
            } else {
                throw new Exception('Validasi gagal');
            }
        }

        if ($newStatus === TestResultStatusEnum::Validated) {
            if ($testResult->status === TestResultStatusEnum::RequestValidate->value) {
                $testResult->validation_date = now();
                $testResult->validator_personel_id = Auth::user()->id;
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
