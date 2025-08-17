<?php

namespace App\Models;

use Database\Factories\CustomerTypeFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    /** @use HasFactory<CustomerTypeFactory> */
    use HasFactory;
    use Blameable;

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
}
