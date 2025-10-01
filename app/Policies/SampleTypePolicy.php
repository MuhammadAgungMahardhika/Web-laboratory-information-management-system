<?php

namespace App\Policies;

use App\Models\SampleType;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class SampleTypePolicy
{
    use HasPolicyAuthorization;
}
