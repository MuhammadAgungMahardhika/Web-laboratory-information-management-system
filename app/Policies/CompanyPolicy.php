<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    use HasPolicyAuthorization;
}
