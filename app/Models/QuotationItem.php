<?php

namespace App\Models;

use Database\Factories\QuoatationItemFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    /** @use HasFactory<QuoatationItemFactory> */
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

    public function invoiceItems()
    {
        return $this->morphMany(InvoiceItem::class, 'source');
    }
    /**
     * Dapatkan total harga dari semua item penawaran.
     * Accessor ini akan secara otomatis diakses saat Anda memanggil $quotation->total_amount.
     */
    protected function getItemTotalAttribute(): float
    {
        return (float) ($this->quantity ?? 0) * ($this->price ?? 0);
    }
}
