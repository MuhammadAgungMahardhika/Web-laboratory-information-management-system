<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelParameter extends Model
{
    /** @use HasFactory<\Database\Factories\PersonelParameterFactory> */
    use HasFactory;
    use Blameable;

    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
