<?php

namespace App\Policies;

use App\Models\Parameter;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class ParameterPolicy
{
    use HasPolicyAuthorization;
}
