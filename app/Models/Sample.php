<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    /** @use HasFactory<\Database\Factories\SampleFactory> */
    use HasFactory;
    use Blameable;


    /**
     * Aksesor untuk mendapatkan pekerjaan lab induk.
     * Tidak perlu relasi baru, cukup panggil melalui labJobItem.
     */
    public function labJob()
    {
        return $this->labJobItem->labJob;
    }
    public function labJobItem()
    {
        return $this->belongsTo(LabJobItem::class);
    }

    public function sampleMatric()
    {
        return $this->belongsTo(SampleMatric::class);
    }

    public function collectedByPersonel()
    {
        return $this->belongsTo(Personel::class, 'collected_by_personel_id');
    }

    public function receivedByPersonel()
    {
        return $this->belongsTo(Personel::class, 'received_by_personel_id');
    }
}
