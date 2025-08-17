<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
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
