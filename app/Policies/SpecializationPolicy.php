<?php

namespace App\Policies;

use App\Models\Specialization;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class SpecializationPolicy
{
    use HasPolicyAuthorization;
}
