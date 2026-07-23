<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Log;

use function Illuminate\Events\queueable;

class TestResult extends Model
{
    protected $casts = [
        'status' => 'integer',
    ];
    /** @use HasFactory<\Database\Factories\TestResultFactory> */
    use HasFactory;
    use Blameable;

    protected static function booted(): void
    {
        $user = Auth::user();
        $personelId =  $user->personel->id ?? null;
        $personelFullname =  $user->personel->fullname ?? null;
        static::updated(queueable(function (TestResult $testResult) use ($personelId, $personelFullname) {
            if ($testResult->isDirty('status') || $testResult->isDirty('tested_value') || $testResult->isDirty('corrected_value') || $testResult->isDirty('notes')) {
                TestResultHistory::create([
                    'test_result_id' => $testResult->id,
                    'personel_id' => $personelId,
                    'old_status' => $testResult->getOriginal('status'),
                    'new_status' => $testResult->status,
                    'old_tested_value' => $testResult->getOriginal('tested_value'),
                    'new_tested_value' => $testResult->tested_value,
                    'comment' => $testResult->comment ?? null,
                    'created_by' =>  $personelFullname ?? 'System',
                    'updated_by' =>  $personelFullname ?? 'System',
                ]);
            }
        }));
    }
    public function sample()
    {
        return $this->belongsTo(Sample::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function testMethod()
    {
        return $this->belongsTo(TestMethod::class);
    }

    public function analystPersonel()
    {
        return $this->belongsTo(Personel::class, 'analyst_personel_id');
    }

    public function validatorPersonel()
    {
        return $this->belongsTo(Personel::class, 'validator_personel_id');
    }

    public function testResultHistories()
    {
        return $this->hasMany(TestResultHistory::class);
    }

    public function test_result_approvals()
    {
        return $this->hasMany(TestResultApproval::class);
    }
    public function scopeVisibleForUser(Builder $query, User $user): Builder
    {
        $specializationIds = $user->personel?->personelSpecializations
            ->pluck('specialization_id')
            ->toArray() ?? [];

        return $query->whereHas('parameter.specialisasiParameters', function ($q) use ($specializationIds) {
            $q->whereIn('specialization_id', $specializationIds);
        });
    }
}
