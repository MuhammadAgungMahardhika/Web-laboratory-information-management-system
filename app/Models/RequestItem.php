<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    /** @use HasFactory<\Database\Factories\RequestItemFactory> */
    use HasFactory;
    use Blameable;
}
