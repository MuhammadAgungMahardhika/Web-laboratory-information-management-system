<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasPolicyAuthorization;

class InvoicePolicy
{
    use HasPolicyAuthorization;
}
