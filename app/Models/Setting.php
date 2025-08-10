<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;
    use Blameable;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function termTemplate()
    {
        return $this->belongsTo(TermTemplate::class);
    }
}
