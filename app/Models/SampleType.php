<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleType extends Model
{
    /** @use HasFactory<\Database\Factories\SampleTypeFactory> */
    use HasFactory;
    use Blameable;
}
