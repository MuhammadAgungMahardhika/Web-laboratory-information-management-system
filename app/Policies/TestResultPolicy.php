<?php

namespace App\Policies;

use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class TestResultPolicy
{
    use HasPolicyAuthorization;

    public function update(User $user, Model $record): bool
    {
        return  static::hasPermission('update', static::getResourceName()) && $record->status === TestResultStatusEnum::Raw->value;
    }

    public function delete(User $user, Model $record): bool
    {
        return static::hasPermission('delete', static::getResourceName()) && $record->status === TestResultStatusEnum::Raw->value;;
    }
}
