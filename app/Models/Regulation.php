<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    /** @use HasFactory<\Database\Factories\RegulationFactory> */
    use HasFactory;
    use Blameable;
}
