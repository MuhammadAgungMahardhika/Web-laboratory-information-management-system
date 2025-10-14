<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceItemFactory> */
    use HasFactory;
    use Blameable;

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function source()
    {
        return $this->morphTo();
    }


    /**
     * Secara dinamis menghitung atribut 'subtotal'.
     *
     * @return float
     */
    public function getSubtotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }
}
