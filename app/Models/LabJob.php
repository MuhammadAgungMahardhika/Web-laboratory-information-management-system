<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabJob extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;
    use Blameable;
    public function labJobItems()
    {
        return $this->hasMany(LabJobItem::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    protected function getTotalPriceAttribute(): float
    {
        return (float) $this->labJobItems()->sum(function ($item) {
            // Access the totalPrice accessor from the QuotationItem model
            return (float) $item->item_total;
        });
    }
}
