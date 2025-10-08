<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResultHistory extends Model
{
    /** @use HasFactory<\Database\Factories\TestResultHistoryFactory> */
    use HasFactory;

    public function testResult()
    {
        return $this->belongsTo(TestResult::class);
    }

    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }
}
