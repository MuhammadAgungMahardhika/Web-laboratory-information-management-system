<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterTestPackage extends Model
{
    /** @use HasFactory<\Database\Factories\ParameterTestPackageFactory> */
    use HasFactory;
    use Blameable;
}
