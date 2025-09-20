<?php

namespace App\Models;

use App\Observers\TestResultObserver;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Log;

use function Illuminate\Events\queueable;

class TestResult extends Model
{
    /** @use HasFactory<\Database\Factories\TestResultFactory> */
    use HasFactory;
    use Blameable;

    protected static function booted(): void
    {
        $personelId = Auth::user()->personel->id ?? null;
        static::updated(queueable(function (TestResult $testResult) use ($personelId) {
            if ($testResult->isDirty('status') || $testResult->isDirty('tested_value') || $testResult->isDirty('corrected_value') || $testResult->isDirty('notes')) {
                TestResultHistory::create([
                    'test_result_id' => $testResult->id,
                    'personel_id' => $personelId,
                    'old_status' => $testResult->getOriginal('status'),
                    'new_status' => $testResult->status,
                    'old_tested_value' => $testResult->getOriginal('tested_value'),
                    'new_tested_value' => $testResult->tested_value,
                    'old_corrected_value' => $testResult->getOriginal('corrected_value'),
                    'new_corrected_value' => $testResult->corrected_value,
                    'notes' => $testResult->notes,
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
}
