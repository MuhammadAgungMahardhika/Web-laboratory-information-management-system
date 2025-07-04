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
        return $this->belongsToMany(Parameter::class, 'quotation_item_parameters');
    }
    public function quotationItemParameters()
    {
        return $this->hasMany(QuotationItemParameter::class);
    }
}
