<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    /** @use HasFactory<\Database\Factories\QuoatationItemFactory> */
    use Blameable;
    use HasFactory;

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function testPackage()
    {
        return $this->belongsTo(TestPackage::class);
    }

    public function regulation()
    {
        return $this->belongsTo(Regulation::class);
    }

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class, 'parameter_quotation_items');
    }
    public function parameterQuotationItems()
    {
        return $this->hasMany(ParameterQuotationItem::class);
    }
}
