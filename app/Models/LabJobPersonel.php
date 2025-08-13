<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabJobPersonel extends Model
{
    /** @use HasFactory<\Database\Factories\LabJobPersonelFactory> */
    use HasFactory;
    use Blameable;

    public function labJob()
    {
        return $this->belongsTo(LabJob::class);
    }

    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }
}
