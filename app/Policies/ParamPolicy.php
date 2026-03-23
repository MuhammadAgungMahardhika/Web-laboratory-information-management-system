<?php

namespace App\Policies;

use App\Models\User;
use App\Models\param;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class ParamPolicy
{
    use HasPolicyAuthorization;
}
