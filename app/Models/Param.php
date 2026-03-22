<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    /** @use HasFactory<\Database\Factories\ParamFactory> */
    protected $primaryKey = 'code';
    use HasFactory;
    use Blameable;

    protected $casts = [
        'code' => 'string',
    ];
    public function parameters()
    {
        return $this->hasMany(Parameter::class, 'code', 'code');
    }
}
