<?php

namespace App\Policies;

use App\Models\SampleMatric;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class SampleMatricPolicy
{
    use HasPolicyAuthorization;
}
