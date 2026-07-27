<?php

namespace App\Observers;

use App\Jobs\RecordTestResultHistoryJob;
use App\Models\Enums\TestResultEvaluationStatusEnum;
use App\Models\Enums\TestResultHistoryActionEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\Personel;
use App\Models\TestMethod;
use App\Models\TestResult;
use App\Models\TestResultHistory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TestResultObserver
{
    public function updated(TestResult $testResult): void
    {
        $trackedFields = [
            'status',
            'tested_value',
            'comment',
            'evaluation_status',
            'validator_personel_id',
            'analyst_personel_id',
            'test_date',
            'test_method_id',
            'unit',
        ];

        if (! $testResult->wasChanged($trackedFields)) {
            return;
        }

        $user = Auth::user();

        $fieldLabels = [
            'status' => 'Status',
            'tested_value' => 'Nilai Hasil Uji',
            'comment' => 'Komentar',
            'evaluation_status' => 'Status Evaluasi',
            'validator_personel_id' => 'Validator',
            'analyst_personel_id' => 'Analis',
            'test_date' => 'Tanggal Uji',
            'test_method_id' => 'Metode Uji',
            'unit' => 'Satuan',
        ];

        $enumFields = [
            'status' => TestResultStatusEnum::labels(),
            'evaluation_status' => TestResultEvaluationStatusEnum::labels(),
        ];

        $personelFields = [
            'validator_personel_id',
            'analyst_personel_id',
        ];

        /*
        |--------------------------------------------------------------------------
        | Personel
        |--------------------------------------------------------------------------
        */

        $personelIds = [];

        foreach ($personelFields as $field) {
            if (! $testResult->wasChanged($field)) {
                continue;
            }

            $personelIds[] = $testResult->getOriginal($field);
            $personelIds[] = $testResult->getAttribute($field);
        }

        $personels = Personel::query()
            ->whereIn('id', array_filter($personelIds))
            ->pluck('fullname', 'id');

        /*
        |--------------------------------------------------------------------------
        | Test Method
        |--------------------------------------------------------------------------
        */

        $testMethodIds = [];

        if ($testResult->wasChanged('test_method_id')) {
            $testMethodIds[] = $testResult->getOriginal('test_method_id');
            $testMethodIds[] = $testResult->getAttribute('test_method_id');
        }

        $testMethods = TestMethod::query()
            ->whereIn('id', array_filter($testMethodIds))
            ->pluck('name', 'id'); // ganti 'name' bila kolomnya berbeda

        /*
        |--------------------------------------------------------------------------
        | Changes
        |--------------------------------------------------------------------------
        */

        $changes = [];

        foreach ($trackedFields as $field) {

            if (! $testResult->wasChanged($field)) {
                continue;
            }

            $old = $this->formatHistoryValue(
                field: $field,
                value: $testResult->getOriginal($field),
                enumFields: $enumFields,
                personelFields: $personelFields,
                personels: $personels,
                testMethods: $testMethods,
            );

            $new = $this->formatHistoryValue(
                field: $field,
                value: $testResult->getAttribute($field),
                enumFields: $enumFields,
                personelFields: $personelFields,
                personels: $personels,
                testMethods: $testMethods,
            );

            $changes[$fieldLabels[$field]] = [
                'old' => $old,
                'new' => $new,
            ];
        }

        if (empty($changes)) {
            return;
        }
        RecordTestResultHistoryJob::dispatch([
            'test_result_id' => $testResult->id,
            'personel_id' => $user?->personel?->id,
            'action' => $this->resolveAction($testResult),
            'changes' => $changes,
            'created_by' => $user?->personel?->fullname ?? 'System',
            'updated_by' => $user?->personel?->fullname ?? 'System',
        ])
            ->afterCommit();
    }

    private function formatHistoryValue(
        string $field,
        mixed $value,
        array $enumFields,
        array $personelFields,
        Collection $personels,
        Collection $testMethods,
    ): mixed {
        if ($value === null) {
            return null;
        }

        // Enum
        if (isset($enumFields[$field])) {
            return $enumFields[$field][$value] ?? $value;
        }

        // Personel
        if (in_array($field, $personelFields, true)) {
            return $personels[$value] ?? $value;
        }

        // Test Method
        if ($field === 'test_method_id') {
            return $testMethods[$value] ?? $value;
        }

        // Date
        if ($field === 'test_date') {
            return Carbon::parse($value)->format('d/m/Y');
        }

        // Unit & field lainnya
        return $value;
    }

    private function resolveAction(TestResult $testResult): TestResultHistoryActionEnum
    {
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

            $oldStatus === TestResultStatusEnum::Raw
                && $newStatus === TestResultStatusEnum::RequestValidate
            => TestResultHistoryActionEnum::Submitted,

            $oldStatus === TestResultStatusEnum::RevisionNeeded
                && $newStatus === TestResultStatusEnum::RequestValidate
            => TestResultHistoryActionEnum::Submitted,

            $oldStatus === TestResultStatusEnum::RequestValidate
                && $newStatus === TestResultStatusEnum::Validated
            => TestResultHistoryActionEnum::Approved,

            $oldStatus === TestResultStatusEnum::RequestValidate
                && $newStatus === TestResultStatusEnum::Rejected
            => TestResultHistoryActionEnum::Rejected,

            $oldStatus === TestResultStatusEnum::RequestValidate
                && $newStatus === TestResultStatusEnum::RevisionNeeded
            => TestResultHistoryActionEnum::Revision,

            $oldStatus === TestResultStatusEnum::Validated
                && $newStatus === TestResultStatusEnum::RevisionNeeded
            => TestResultHistoryActionEnum::Reopened,

            default => TestResultHistoryActionEnum::Updated,
        };
    }
}
