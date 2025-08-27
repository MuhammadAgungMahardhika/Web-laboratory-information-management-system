<?php

namespace App\Policies;

use App\Models\Sample;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class SamplePolicy
{
    use HasPolicyAuthorization;
}
