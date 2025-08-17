<?php

namespace App\Models;

use Database\Factories\TestMethodFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestMethod extends Model
{
    /** @use HasFactory<TestMethodFactory> */
    use HasFactory;
    use Blameable;

    public function parameter()
    {
        return $this->hasMany(Parameter::class);
    }
}
