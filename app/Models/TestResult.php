<?php

namespace App\Models;

use App\Observers\TestResultObserver;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Log;

use function Illuminate\Events\queueable;

#[ObservedBy([TestResultObserver::class])]
class TestResult extends Model
{
    protected $casts = [
        'status' => 'integer',
    ];
    /** @use HasFactory<\Database\Factories\TestResultFactory> */
    use HasFactory;
    use Blameable;


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

    public function testResultApprovals()
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
