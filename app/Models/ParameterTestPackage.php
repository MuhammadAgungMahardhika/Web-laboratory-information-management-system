<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterTestPackage extends Model
{
    /** @use HasFactory<\Database\Factories\ParameterTestPackageFactory> */
    use HasFactory;
    use Blameable;

    public function testPackage()
    {
        return $this->belongsTo(TestPackage::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
