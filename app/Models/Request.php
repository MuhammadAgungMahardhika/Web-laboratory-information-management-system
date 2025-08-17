<?php

namespace App\Models;

use Database\Factories\RequestFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    /** @use HasFactory<RequestFactory> */
    use Blameable;
    use HasFactory;

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
