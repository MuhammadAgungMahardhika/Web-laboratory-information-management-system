<?php

namespace App\Policies;

use App\Models\TestPackage;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class TestPackagePolicy
{
    use HasPolicyAuthorization;
}
