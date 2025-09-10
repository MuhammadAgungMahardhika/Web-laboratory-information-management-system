<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    /** @use HasFactory<\Database\Factories\SpecializationFactory> */
    use HasFactory;
    use Blameable;


    public function specialisasiParameters()
    {
        return $this->hasMany(SpecialisasiParameters::class);
    }
    public function personelSpecializations()
    {
        return $this->hasMany(PersonelSpecialization::class);
    }
    public function personels()
    {
        return $this->belongsToMany(Personel::class, 'personel_specializations');
    }

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class, 'specialisasi_parameters');
    }
}
