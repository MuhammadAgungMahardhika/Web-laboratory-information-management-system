<?php

namespace App\Models;

use App\Policies\LabJobPolicy;
use Database\Factories\JobFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class LabJob extends Model
{
    protected $casts = [
        'status' => 'integer',
    ];
    /** @use HasFactory<JobFactory> */
    use HasFactory;
    use Blameable;

    public function samples(): HasManyThrough
    {
        return $this->hasManyThrough(Sample::class, LabJobItem::class);
    }
    public function labJobItems()
    {
        return $this->hasMany(LabJobItem::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function labJobPersonels()
    {
        return $this->hasMany(LabJobPersonel::class);
    }

    public function personels()
    {
        return $this->belongsToMany(Personel::class, 'lab_job_personels');
    }
    protected function getTotalPriceAttribute(): float
    {
        return (float) $this->labJobItems()->sum(function ($item) {
            // Access the totalPrice accessor from the QuotationItem model
            return (float) $item->item_total;
        });
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
