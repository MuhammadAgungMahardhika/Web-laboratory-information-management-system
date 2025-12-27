<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulationType extends Model
{
    /** @use HasFactory<\Database\Factories\RegulationTypeFactory> */
    use HasFactory;
    use Blameable;

    public function regulations()
    {
        return $this->hasMany(Regulation::class);
    }
}
