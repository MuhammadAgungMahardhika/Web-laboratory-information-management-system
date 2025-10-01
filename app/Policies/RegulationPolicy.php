<?php

namespace App\Policies;

use App\Models\Regulation;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class RegulationPolicy
{
    use HasPolicyAuthorization;
}
