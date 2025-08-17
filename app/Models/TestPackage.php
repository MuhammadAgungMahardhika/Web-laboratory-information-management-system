<?php

namespace App\Models;

use Database\Factories\TestPackageFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPackage extends Model
{
    /** @use HasFactory<TestPackageFactory> */
    use HasFactory;
    use Blameable;

    public function sampleMatric()
    {
        return $this->belongsTo(SampleMatric::class);
    }

    public function regulation()
    {
        return $this->belongsTo(Regulation::class);
    }
    public function parameterTestPackages()
    {
        return $this->hasMany(ParameterTestPackage::class);
    }
    public function parameters()
    {
        return $this->belongsToMany(Parameter::class, 'parameter_test_packages');
    }
}
