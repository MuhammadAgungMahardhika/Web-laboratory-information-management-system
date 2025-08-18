<?php

namespace App\Models;

use Database\Factories\LabJobItemFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabJobItem extends Model
{
    /** @use HasFactory<LabJobItemFactory> */
    use HasFactory;
    use Blameable;


    public function samples()
    {
        return $this->hasMany(Sample::class);
    }
    public function labJob()
    {
        return $this->belongsTo(LabJob::class);
    }
    public function quotationItem()
    {
        return $this->belongsTo(QuotationItem::class);
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
        return $this->belongsToMany(Parameter::class, 'parameter_lab_job_items');
    }
    public function parameterLabJobItems()
    {
        return $this->hasMany(ParameterLabJobItem::class);
    }

    /**
     * Dapatkan total harga dari semua item penawaran.
     * Accessor ini akan secara otomatis diakses saat Anda memanggil $labjob->total_amount.
     */
    protected function getItemTotalAttribute(): float
    {
        return (float) ($this->quantity ?? 0) * ($this->price ?? 0);
    }
}
