<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoatationItem extends Model
{
    /** @use HasFactory<\Database\Factories\QuoatationItemFactory> */
    use Blameable;
    use HasFactory;

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
