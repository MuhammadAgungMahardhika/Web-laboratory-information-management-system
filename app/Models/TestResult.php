<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
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
}
