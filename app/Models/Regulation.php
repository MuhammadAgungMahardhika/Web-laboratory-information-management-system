<?php

namespace App\Models;

use Database\Factories\RegulationFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    /** @use HasFactory<RegulationFactory> */
    use HasFactory;
    use Blameable;

    public function testPackages()
    {
        return $this->hasMany(TestPackage::class);
    }

    public function regulationType()
    {
        return $this->belongsTo(RegulationType::class);
    }
}
