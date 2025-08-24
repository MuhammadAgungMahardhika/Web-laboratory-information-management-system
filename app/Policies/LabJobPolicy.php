<?php

namespace App\Policies;

use App\Models\Enums\JobStatusEnum;
use App\Models\LabJob;
use App\Models\User;
use App\Traits\HasAuthorization;
use App\Traits\HasPolicyAuthorization;
use Auth;
use Illuminate\Auth\Access\Response;

class LabJobPolicy
{
    use HasPolicyAuthorization;

    public function update(User $user, LabJob $labJob): bool
    {
        // Panggil izin dasar dari trait, lalu tambahkan kondisi khusus
        return static::hasPermission('update', static::getResourceName()) && $labJob->status === JobStatusEnum::PendingStart->value;
    }
    public function delete(User $user, LabJob $labJob): bool
    {
        // Panggil izin dasar dari trait, lalu tambahkan kondisi khusus
        return static::hasPermission('delete', static::getResourceName()) && $labJob->status === JobStatusEnum::PendingStart->value;
    }
}
