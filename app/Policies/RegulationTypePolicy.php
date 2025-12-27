<?php

namespace App\Policies;

use App\Models\RegulationType;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class RegulationTypePolicy
{
    use HasPolicyAuthorization;
}
