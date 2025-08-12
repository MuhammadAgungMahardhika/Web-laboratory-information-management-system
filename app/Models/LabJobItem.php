<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabJobItem extends Model
{
    /** @use HasFactory<\Database\Factories\LabJobItemFactory> */
    use HasFactory;
    use Blameable;

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
}
