<?php

namespace App\Policies;

use App\Models\TestMethod;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class TestMethodPolicy
{
    use HasPolicyAuthorization;
}
