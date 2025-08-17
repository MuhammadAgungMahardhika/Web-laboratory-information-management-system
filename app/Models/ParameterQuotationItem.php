<?php

namespace App\Models;

use Database\Factories\ParameterQuotationItemFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterQuotationItem extends Model
{
    /** @use HasFactory<ParameterQuotationItemFactory> */
    use HasFactory;
    use Blameable;


    public function quotationItem()
    {
        return $this->belongsTo(QuotationItem::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
