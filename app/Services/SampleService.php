<?php

namespace App\Services;

use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\LabJobItem;
use App\Models\Sample;
use Exception;

class SampleService
{
    /**
     * Generate kode sampel.
     *
     * Example:
     * LAB-JLI-26070001-01-S01
     * LAB-JLI-26070001-01-S02
     */
    public function generateSampleCode(
        LabJobItem $labJobItem
    ): string {

        $sampleCount = $labJobItem
            ->samples()
            ->count();


        $sequence = str_pad(
            $sampleCount + 1,
            2,
            '0',
            STR_PAD_LEFT
        );


        return "{$labJobItem->code}-S{$sequence}";
    }

    /**
     * Update status Sample.
     */
    public function updateSampleStatus(
        Sample $sample,
        SampleStatusEnum $newStatus,
    ): bool {

        $testResultService = app(TestResultService::class);

        switch ($newStatus) {

            /*
            |--------------------------------------------------------------------------
            | RECEIVED
            |--------------------------------------------------------------------------
            */
            case SampleStatusEnum::Received:

                if ($sample->status !== SampleStatusEnum::Prepared->value) {
                    throw new Exception(
                        "Status sampel hanya dapat dikembalikan ke Received dari Prepared."
                    );
                }

                $sample->status = SampleStatusEnum::Received->value;

                return $sample->save();

                /*
            |--------------------------------------------------------------------------
            | PREPARED
            |--------------------------------------------------------------------------
            */
            case SampleStatusEnum::Prepared:

                if (! in_array($sample->status, [SampleStatusEnum::Received->value, SampleStatusEnum::AnalysisCompleted->value,])) {
                    throw new Exception(
                        "Status sampel tidak dapat diubah menjadi Prepared."
                    );
                }

                if ($sample->labJobItem->labJob->status !== JobStatusEnum::SamplingCompleted->value) {
                    throw new Exception(
                        "Status Job belum Complete Sampling."
                    );
                }

                /**
                 * Pertama kali menjadi Prepared
                 */
                if ($sample->status === SampleStatusEnum::Received->value) {
                    $testResultService->generateTestResultsFromSample($sample);
                }

                /**
                 * Re-open setelah selesai analisa
                 */
                if ($sample->status === SampleStatusEnum::AnalysisCompleted->value) {
                    $testResultService->reopenTestResultsFromSample($sample);
                }

                $sample->status = SampleStatusEnum::Prepared->value;

                return $sample->save();

                /*
            |--------------------------------------------------------------------------
            | ANALYSIS COMPLETED
            |--------------------------------------------------------------------------
            */
            case SampleStatusEnum::AnalysisCompleted:

                $hasUnvalidated = $sample
                    ->testResults()
                    ->where(
                        'status',
                        '!=',
                        TestResultStatusEnum::Validated->value
                    )
                    ->exists();

                if ($hasUnvalidated) {
                    throw new Exception(
                        "Masih ada hasil uji yang belum divalidasi."
                    );
                }

                $sample->status = SampleStatusEnum::AnalysisCompleted->value;

                return $sample->save();
        }

        return false;
    }
}
