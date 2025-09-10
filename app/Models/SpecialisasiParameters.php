<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialisasiParameters extends Model
{
    /** @use HasFactory<\Database\Factories\SpecialisasiParametersFactory> */
    use HasFactory;
    use Blameable;

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
