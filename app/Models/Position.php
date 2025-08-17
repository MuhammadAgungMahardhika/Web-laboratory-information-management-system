<?php

namespace App\Models;

use Database\Factories\PositionFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /** @use HasFactory<PositionFactory> */
    use HasFactory;
    use Blameable;

    public function personels()
    {
        return $this->hasMany(Personel::class);
    }
}
