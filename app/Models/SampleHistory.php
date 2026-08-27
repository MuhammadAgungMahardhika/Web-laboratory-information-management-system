<?php

namespace App\Models;

use App\Models\Enums\SampleHistoryActionEnum;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleHistory extends Model
{
    /** @use HasFactory<\Database\Factories\SampleHistoryFactory> */
    use HasFactory;

    protected $casts = [
        'action' => SampleHistoryActionEnum::class,
        'changes' => 'array',
    ];
    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }
    public function sample()
    {
        return $this->belongsTo(Sample::class);
    }
}
