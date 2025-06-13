<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestMethod extends Model
{
    /** @use HasFactory<\Database\Factories\TestMethodFactory> */
    use HasFactory;
    use Blameable;

    public function parameter()
    {
        return $this->hasMany(Parameter::class);
    }
}
