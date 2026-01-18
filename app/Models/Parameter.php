<?php

namespace App\Models;

use Database\Factories\ParameterFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    /** @use HasFactory<ParameterFactory> */
    use HasFactory;
    use Blameable;

    protected $casts = [
        'standard_notes' => 'array',
    ];
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'specialisasi_parameters');
    }

    public function specialisasiParameters()
    {
        return $this->hasMany(SpecialisasiParameters::class);
    }

    public function personels()
    {
        return $this->belongsToMany(Personel::class, 'personel_parameters');
    }
    public function testMethod()
    {
        return $this->belongsTo(TestMethod::class);
    }

    // test package
    public function testPackages()
    {
        return $this->belongsToMany(TestPackage::class, 'parameter_test_packages'); // butuh perbaikan 
    }

    public function parameterTestPackages()
    {
        return $this->hasMany(ParameterTestPackage::class);
    }

    // labjob
    public function labJobItems()
    {
        return $this->belongsToMany(LabJobItem::class, 'parameter_lab_job_items');
    }
    public function parameterLabJobItems()
    {
        return $this->hasMany(ParameterLabJobItem::class);
    }

    // quotation
    public function quotationItems()
    {
        return $this->belongsToMany(QuotationItem::class, 'parameter_quotation_items');
    }
    public function parameterQuotationItems()
    {
        return $this->hasMany(ParameterQuotationItem::class);
    }
}
