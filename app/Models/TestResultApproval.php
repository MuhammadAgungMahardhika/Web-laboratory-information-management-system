<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResultApproval extends Model
{
    /** @use HasFactory<\Database\Factories\TestResultApprovalFactory> */
    use HasFactory;
    use Blameable;

    protected $casts = [
        'personel_id' => 'integer',
        'approval_level' => 'integer',
    ];
    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }
    public function testResult()
    {
        return $this->belongsTo(TestResult::class);
    }
}
