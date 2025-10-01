<?php

namespace App\Policies;

use App\Models\TermTemplate;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class TermTemplatePolicy
{
    use HasPolicyAuthorization;
}
