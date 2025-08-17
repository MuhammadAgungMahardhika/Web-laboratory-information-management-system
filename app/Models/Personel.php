<?php

namespace App\Models;

use Database\Factories\PersonelFactory;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    /** @use HasFactory<PersonelFactory> */
    use HasFactory;
    use Blameable;

    public function labJobPersonels()
    {
        return $this->hasMany(LabJobPersonel::class);
    }
    public function labJobs()
    {
        return $this->hasMany(LabJob::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
    public function approvedQuotations()
    {
        return $this->hasMany(Quotation::class, 'approved_by_personel_id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
