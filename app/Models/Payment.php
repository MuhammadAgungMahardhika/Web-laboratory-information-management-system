<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Blameable;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    protected $casts = [
        'status' => 'integer',
    ];


    use Blameable;
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
