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
        $hasPermission = static::hasPermission('update', static::getResourceName());

        $isEditableStatus = in_array($record->status, [
            TestResultStatusEnum::Raw->value,
            TestResultStatusEnum::RevisionNeeded->value,
        ], true);

        $hasSpecializationMatch = $user->personel?->specializations
            ?->pluck('id')
            ->intersect($record->parameter?->specializations?->pluck('id') ?? collect())
            ->isNotEmpty();


        return $hasPermission && $isEditableStatus && $hasSpecializationMatch;
    }

    public function delete(User $user, Model $record): bool
    {
        return static::hasPermission('delete', static::getResourceName()) && $record->status === TestResultStatusEnum::Raw->value;
    }
}
