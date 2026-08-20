<?php

namespace App\Models;

use App\Models\Enums\InvoiceStatusEnum;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'status' => 'integer',
    ];
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;
    use Blameable;

    public function getStatusEnumAttribute(): InvoiceStatusEnum
    {
        return InvoiceStatusEnum::from($this->status);
    }
    public function labJob()
    {
        return $this->belongsTo(LabJob::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
