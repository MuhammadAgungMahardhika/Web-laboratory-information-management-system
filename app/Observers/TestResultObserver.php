<?php

namespace App\Observers;

use App\Models\Enums\TestResultEvaluationStatusEnum;
use App\Models\Enums\TestResultHistoryActionEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Models\TestResultHistory;
use Illuminate\Support\Facades\Auth;

class TestResultObserver
{
    public function updated(TestResult $testResult): void
    {
        if (! $testResult->wasChanged([
            'status',
            'tested_value',
            'comment',
            'evaluation_status',
            'validator_personel_id',
            'analyst_personel_id',
            'test_date',
        ])) {
            return;
        }

        $user = Auth::user();

        $changes = [];

        $enumFields = [
            'status' => TestResultStatusEnum::labels(),
            'evaluation_status' => TestResultEvaluationStatusEnum::labels(),
        ];

        $trackedFields = [
            'status',
            'tested_value',
            'comment',
            'evaluation_status',
        ];

        $changes = [];

        foreach ($trackedFields as $field) {

            if (! $testResult->wasChanged($field)) {
                continue;
            }

            $old = $testResult->getOriginal($field);
            $new = $testResult->getAttribute($field);

            // Format enum jika field merupakan enum
            if (isset($enumFields[$field])) {
                $labels = $enumFields[$field];

                $old = $old !== null && array_key_exists($old, $labels)
                    ? $labels[$old]
                    : $old;

                $new = $new !== null && array_key_exists($new, $labels)
                    ? $labels[$new]
                    : $new;
            }

            $changes[$field] = [
                'old' => $old,
                'new' => $new,
            ];
        }

        TestResultHistory::create([
            'test_result_id' => $testResult->id,
            'personel_id' => $user?->personel?->id,
            'old_status' => $testResult->getOriginal('status'),
            'new_status' => $testResult->status,
            'old_tested_value' => $testResult->getOriginal('tested_value'),
            'new_tested_value' => $testResult->tested_value,
            'comment' => $testResult->comment,
            'action' => $this->resolveAction($testResult),
            'changes' => $changes,
            'created_by' => $user?->personel?->fullname ?? 'System',
            'updated_by' => $user?->personel?->fullname ?? 'System',
        ]);
    }

    private function resolveAction(TestResult $testResult): TestResultHistoryActionEnum
    {
        // Jika status tidak berubah, berarti hanya update data
        if (! $testResult->wasChanged('status')) {
            return TestResultHistoryActionEnum::Updated;
        }

        $oldStatus = TestResultStatusEnum::from(
            $testResult->getOriginal('status')
        );

        $newStatus = TestResultStatusEnum::from(
            $testResult->status
        );

        return match (true) {

            // Draft -> Request Validasi
            $oldStatus === TestResultStatusEnum::Raw
                && $newStatus === TestResultStatusEnum::RequestValidate
            => TestResultHistoryActionEnum::Submitted,

            // Perlu Revisi -> Request Validasi
            $oldStatus === TestResultStatusEnum::RevisionNeeded
                && $newStatus === TestResultStatusEnum::RequestValidate
            => TestResultHistoryActionEnum::Submitted,

            // Request Validasi -> Tervalidasi
            $oldStatus === TestResultStatusEnum::RequestValidate
                && $newStatus === TestResultStatusEnum::Validated
            => TestResultHistoryActionEnum::Approved,

            // Request Validasi -> Ditolak
            $oldStatus === TestResultStatusEnum::RequestValidate
                && $newStatus === TestResultStatusEnum::Rejected
            => TestResultHistoryActionEnum::Rejected,

            // Request Validasi -> Perlu Revisi
            $oldStatus === TestResultStatusEnum::RequestValidate
                && $newStatus === TestResultStatusEnum::RevisionNeeded
            => TestResultHistoryActionEnum::Revision,

            // Tervalidasi -> Perlu Revisi (Reopen)
            $oldStatus === TestResultStatusEnum::Validated
                && $newStatus === TestResultStatusEnum::RevisionNeeded
            => TestResultHistoryActionEnum::Reopened,

            default => TestResultHistoryActionEnum::Updated,
        };
    }
}
