<?php

namespace App\Policies;

use App\Models\TestResult;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class TestResultPolicy
{
    use HasPolicyAuthorization;
}
