<?php

namespace App\Models;

use Database\Factories\SampleMatricFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleMatric extends Model
{
    /** @use HasFactory<SampleMatricFactory> */
    protected $primaryKey = 'code';
    use HasFactory;
    use Blameable;

    protected $casts = [
        'code' => 'string',
    ];
    public function samples()
    {
        return $this->hasMany(Sample::class);
    }
    public function sampleType()
    {
        return $this->belongsTo(SampleType::class);
    }

    public function sampleMatrics()
    {
        return $this->hasMany(TestPackage::class, 'sample_matric_code', 'code');
    }
}
