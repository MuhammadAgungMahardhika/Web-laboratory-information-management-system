<?php

namespace App\Models\Enums;

enum TestResultApprovalStatusEnum: string
{
    case Pending  = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Revision = 'revision';
}
