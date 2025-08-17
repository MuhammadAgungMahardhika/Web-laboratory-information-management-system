<?php

namespace App\Models;

use Database\Factories\ProvinceFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    /** @use HasFactory<ProvinceFactory> */
    use HasFactory;
    use Blameable;

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
