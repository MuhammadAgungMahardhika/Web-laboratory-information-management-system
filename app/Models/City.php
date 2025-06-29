<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;
    use Blameable;

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
