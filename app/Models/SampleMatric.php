<?php

namespace App\Models;

use Database\Factories\SampleMatricFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleMatric extends Model
{
    /** @use HasFactory<SampleMatricFactory> */
    use HasFactory;

    use Blameable;
    public function sampleType()
    {
        return $this->belongsTo(SampleType::class);
    }

    public function sampleMatrics()
    {
        return $this->hasMany(TestPackage::class);
    }
}
