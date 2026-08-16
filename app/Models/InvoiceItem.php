<?php

namespace App\Models;

use App\Observers\InvoiceItemObserver;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy([InvoiceItemObserver::class])]
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
