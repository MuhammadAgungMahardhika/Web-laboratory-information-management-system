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
    public function testMethod()
    {
        return $this->belongsTo(TestMethod::class);
    }

    public function testPackages()
    {
        return $this->belongsToMany(TestPackage::class, 'parameter_test_packages'); // butuh perbaikan 
    }

    public function parameterTestPackages()
    {
        return $this->hasMany(ParameterTestPackage::class);
    }

    public function quotationItems()
    {
        return $this->belongsToMany(QuotationItem::class, 'parameter_quotation_items');
    }
    public function parameterQuotationItem()
    {
        return $this->hasMany(ParameterQuotationItem::class);
    }
}
