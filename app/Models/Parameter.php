<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    /** @use HasFactory<\Database\Factories\ParameterFactory> */
    use HasFactory;
    use Blameable;
    public function testMethod()
    {
        return $this->belongsTo(TestMethod::class);
    }

    public function testPackages()
    {
        return $this->belongsToMany(TestPackage::class);
    }
}
