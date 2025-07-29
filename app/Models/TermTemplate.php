<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\TermTemplateFactory> */
    use HasFactory;
    use Blameable;
}
