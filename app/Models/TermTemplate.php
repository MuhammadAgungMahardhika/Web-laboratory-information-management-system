<?php

namespace App\Models;

use Database\Factories\TermTemplateFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermTemplate extends Model
{
    /** @use HasFactory<TermTemplateFactory> */
    use HasFactory;
    use Blameable;

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
}
