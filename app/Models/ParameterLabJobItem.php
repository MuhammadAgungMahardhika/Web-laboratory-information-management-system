<?php

namespace App\Models;

use Database\Factories\ParameterLabJobItemFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterLabJobItem extends Model
{
    /** @use HasFactory<ParameterLabJobItemFactory> */
    use HasFactory;
    use Blameable;

    public function labJobItem()
    {
        return $this->belongsTo(LabJobItem::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
