<?php

namespace App\Observers;

use App\Jobs\RecordSampleHistoryJob;
use App\Models\Enums\SampleCollectionTypeEnum;
use App\Models\Enums\SampleHistoryActionEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\Personel;
use App\Models\Sample;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SampleObserver
{
    public function updated(Sample $sample): void
    {
        $trackedFields = [
            'code',
            'collected_by_personel_id',
            'received_by_personel_id',
            'collection_date',
            'collection_time',
            'collection_location_desc',
            'latitude',
            'longitude',
            'preservation_method',
            'collection_notes',
            'received_date',
            'received_time',
            'received_condition_notes',
            'container_type',
            'container_quantity',
            'sample_volume',
            'analyzed_start_date',
            'analyzed_end_date',
            'collection_type',
            'status',
        ];

        if (! $sample->wasChanged($trackedFields)) {
            return;
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Field Labels
        |--------------------------------------------------------------------------
        */

        $fieldLabels = [
            'code' => 'Kode Sampel',
            'collected_by_personel_id' => 'Petugas Pengambil Sampel',
            'received_by_personel_id' => 'Petugas Penerima Sampel',
            'collection_date' => 'Tanggal Pengambilan',
            'collection_time' => 'Waktu Pengambilan',
            'collection_location_desc' => 'Lokasi Pengambilan',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'preservation_method' => 'Metode Pengawetan',
            'collection_notes' => 'Catatan Pengambilan',
            'received_date' => 'Tanggal Penerimaan',
            'received_time' => 'Waktu Penerimaan',
            'received_condition_notes' => 'Kondisi Sampel Saat Diterima',
            'container_type' => 'Jenis Wadah',
            'container_quantity' => 'Jumlah Wadah',
            'sample_volume' => 'Volume Sampel',
            'analyzed_start_date' => 'Tanggal Mulai Analisis',
            'analyzed_end_date' => 'Tanggal Selesai Analisis',
            'collection_type' => 'Jenis Pengambilan',
            'status' => 'Status',
        ];

        /*
        |--------------------------------------------------------------------------
        | Enum Fields
        |--------------------------------------------------------------------------
        */

        $enumFields = [
            'status' => SampleStatusEnum::labels(),
            'collection_type' => SampleCollectionTypeEnum::labels(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Personel Fields
        |--------------------------------------------------------------------------
        */

        $personelFields = [
            'collected_by_personel_id',
            'received_by_personel_id',
        ];

        $personelIds = [];

        foreach ($personelFields as $field) {
            if (! $sample->wasChanged($field)) {
                continue;
            }

            $personelIds[] = $sample->getOriginal($field);
            $personelIds[] = $sample->getAttribute($field);
        }

        $personels = Personel::query()
            ->whereIn('id', array_filter($personelIds))
            ->pluck('fullname', 'id');

        /*
        |--------------------------------------------------------------------------
        | Changes
        |--------------------------------------------------------------------------
        */

        $changes = [];

        foreach ($trackedFields as $field) {

            if (! $sample->wasChanged($field)) {
                continue;
            }

            $old = $this->formatHistoryValue(
                field: $field,
                value: $sample->getOriginal($field),
                enumFields: $enumFields,
                personelFields: $personelFields,
                personels: $personels,
            );

            $new = $this->formatHistoryValue(
                field: $field,
                value: $sample->getAttribute($field),
                enumFields: $enumFields,
                personelFields: $personelFields,
                personels: $personels,
            );

            $changes[$fieldLabels[$field]] = [
                'old' => $old,
                'new' => $new,
            ];
        }

        if (empty($changes)) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Record History
        |--------------------------------------------------------------------------
        */

        RecordSampleHistoryJob::dispatch([
            'sample_id' => $sample->id,
            'personel_id' => $user?->personel?->id,
            'action' => $this->resolveAction($sample),
            'changes' => $changes,
            'created_by' => $user?->personel?->fullname ?? 'System',
            'updated_by' => $user?->personel?->fullname ?? 'System',
        ])->afterCommit();
    }

    private function formatHistoryValue(
        string $field,
        mixed $value,
        array $enumFields,
        array $personelFields,
        Collection $personels,
    ): mixed {
        if ($value === null) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Enum
        |--------------------------------------------------------------------------
        */

        if (isset($enumFields[$field])) {
            return $enumFields[$field][$value] ?? $value;
        }

        /*
        |--------------------------------------------------------------------------
        | Personel
        |--------------------------------------------------------------------------
        */

        if (in_array($field, $personelFields, true)) {
            return $personels[$value] ?? $value;
        }

        /*
        |--------------------------------------------------------------------------
        | Date
        |--------------------------------------------------------------------------
        */

        if (in_array($field, [
            'collection_date',
            'received_date',
            'analyzed_start_date',
            'analyzed_end_date',
        ], true)) {
            return Carbon::parse($value)->format('d/m/Y');
        }

        /*
        |--------------------------------------------------------------------------
        | Time
        |--------------------------------------------------------------------------
        */

        if (in_array($field, [
            'collection_time',
            'received_time',
        ], true)) {
            return Carbon::parse($value)->format('H:i');
        }

        return $value;
    }

    private function resolveAction(Sample $sample): SampleHistoryActionEnum
    {
        /*
        |--------------------------------------------------------------------------
        | Tidak ada perubahan status
        |--------------------------------------------------------------------------
        */

        if (! $sample->wasChanged('status')) {
            return SampleHistoryActionEnum::Updated;
        }

        $oldStatus = SampleStatusEnum::from(
            (int) $sample->getOriginal('status')
        );

        $newStatus = SampleStatusEnum::from(
            (int) $sample->status
        );

        return match (true) {

            /*
            |--------------------------------------------------------------------------
            | Collected → Received
            |--------------------------------------------------------------------------
            */

            $oldStatus === SampleStatusEnum::Collected
                && $newStatus === SampleStatusEnum::Received
            => SampleHistoryActionEnum::Received,

            /*
            |--------------------------------------------------------------------------
            | Received → Prepared
            |--------------------------------------------------------------------------
            */

            $oldStatus === SampleStatusEnum::Received
                && $newStatus === SampleStatusEnum::Prepared
            => SampleHistoryActionEnum::Prepared,

            /*
            |--------------------------------------------------------------------------
            | Prepared → Analysis Completed
            |--------------------------------------------------------------------------
            */

            $oldStatus === SampleStatusEnum::Prepared
                && $newStatus === SampleStatusEnum::AnalysisCompleted
            => SampleHistoryActionEnum::AnalysisCompleted,

            /*
            |--------------------------------------------------------------------------
            | → Invalid
            |--------------------------------------------------------------------------
            */

            $newStatus === SampleStatusEnum::Invalid
            => SampleHistoryActionEnum::Invalid,

            /*
            |--------------------------------------------------------------------------
            | → Archived
            |--------------------------------------------------------------------------
            */

            $newStatus === SampleStatusEnum::Archived
            => SampleHistoryActionEnum::Archived,

            /*
            |--------------------------------------------------------------------------
            | Default
            |--------------------------------------------------------------------------
            */

            default => SampleHistoryActionEnum::Updated,
        };
    }
}
