<?php

namespace App\Models;

use Database\Factories\RequestItemFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    /** @use HasFactory<RequestItemFactory> */
    use HasFactory;
    use Blameable;
}
