<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;
    use Blameable;

    public function personnels()
    {
        return $this->hasMany(Personel::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function setMailPasswordAttribute($value)
    {
        if (filled($value)) { // Hanya proses jika ada nilai non-kosong yang diberikan
            $this->attributes['mail_password'] = Crypt::encryptString($value);
        }
        // Jika $value kosong (null atau string kosong), kita tidak melakukan apa-apa,
        // sehingga password yang sudah ada di DB (dari $this->attributes['mail_password'] sebelumnya)
        // akan tetap tidak berubah. Ini berlaku untuk operasi update.
    }
}
