<?php

namespace App\Policies;

use App\Models\Personel;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class PersonelPolicy
{
    use HasPolicyAuthorization;
}
