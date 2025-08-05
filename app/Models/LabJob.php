<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabJob extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;
    use Blameable;
    

    public function quotation(){
        return $this->belongsTo(Quotation::class);
    }

}
