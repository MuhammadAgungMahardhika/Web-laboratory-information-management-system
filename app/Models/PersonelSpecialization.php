<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelSpecialization extends Model
{
    //
    use HasFactory;
    use Blameable;

    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
