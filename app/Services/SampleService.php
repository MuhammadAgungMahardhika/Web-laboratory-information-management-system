<?php

namespace App\Services;

use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\LabJobItem;
use App\Models\Sample;
use Exception;
use Illuminate\Support\Facades\DB;

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
        $lastSequence = $labJobItem->samples()
            ->selectRaw("
        MAX(
            CAST(
                SUBSTRING_INDEX(code, '-S', -1) AS UNSIGNED
            )
        ) as last_sequence
    ")->value('last_sequence') ?? 0;

        $sequence = str_pad($lastSequence + 1, 2, '0', STR_PAD_LEFT);

        return "{$labJobItem->code}-S{$sequence}";
    }
    /**
     * Membuat sampel baru.
     */
    public function create(LabJobItem $labJobItem, array $data): Sample
    {
        return DB::transaction(function () use ($labJobItem, $data) {
            $data['lab_job_item_id'] = $labJobItem->id;
            $data['code'] = $this->generateSampleCode($labJobItem);
            return Sample::create($data);
        });
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
            | COLLECTED
            |--------------------------------------------------------------------------
            */
            case SampleStatusEnum::Collected:

                if (in_array($sample->status, [SampleStatusEnum::Received->value, SampleStatusEnum::Prepared->value, SampleStatusEnum::AnalysisCompleted->value])) {
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
                /*
            |--------------------------------------------------------------------------
            | RECEIVED
            |--------------------------------------------------------------------------
            */
            case SampleStatusEnum::Received:

                if ($sample->status !== SampleStatusEnum::Collected->value) {
                    throw new Exception(
                        "Status sampel tidak dapat diubah menjadi Received."
                    );
                }
                if ($sample->labJobItem->labJob->status !== JobStatusEnum::Sampling->value) {
                    throw new Exception(
                        "Status Job belum Belum Progres."
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

                if ($sample->status !== SampleStatusEnum::Received->value) {
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

    public function reopen(
        Sample $sample,
        string $reason,
    ): bool {
        return DB::transaction(function () use ($sample, $reason) {
            $testResultService = app(TestResultService::class);
            if ($sample->status !== SampleStatusEnum::AnalysisCompleted->value) {
                throw new Exception("Hanya sampel dengan status Analysis Completed yang dapat direopen.");
            }



            if ($sample->labJobItem->labJob->status !== JobStatusEnum::AnalysisCompleted->value) {
                throw new Exception("Job belum berada pada status Selesai Analisis.");
            }


            $testResultService->reopenTestResultsFromSample($sample);
            $sample->status = SampleStatusEnum::Prepared->value;

            // Kalau sudah ada kolom reason:
            // $sample->reopen_reason = $reason;

            return $sample->save();
        });
    }
}
