<?php

namespace App\Policies;

use App\Models\CustomerType;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class CustomerTypePolicy
{
    use HasPolicyAuthorization;
}
