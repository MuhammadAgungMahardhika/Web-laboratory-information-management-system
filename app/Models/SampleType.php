<?php

namespace App\Models;

use Database\Factories\SampleTypeFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleType extends Model
{
    /** @use HasFactory<SampleTypeFactory> */
    use HasFactory;
    use Blameable;
}
