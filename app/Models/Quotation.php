<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationFactory> */
    use Blameable;
    use HasFactory;

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }
    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }
}
