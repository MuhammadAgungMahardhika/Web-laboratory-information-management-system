<?php

namespace App\Policies;

use App\Models\Enums\SampleStatusEnum;
use App\Models\Sample;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class SamplePolicy
{
    use HasPolicyAuthorization;

    public function update(User $user, Sample $sample): bool
    {
        // Panggil izin dasar dari trait, lalu tambahkan kondisi khusus
        return static::hasPermission('update', static::getResourceName()) &&  in_array($sample->status, [
            SampleStatusEnum::Collected->value
        ]);
    }
    public function delete(User $user, Sample $sample): bool
    {
        // Panggil izin dasar dari trait, lalu tambahkan kondisi khusus
        return static::hasPermission('delete', static::getResourceName()) && in_array($sample->status, [
            SampleStatusEnum::Collected->value
        ]);
    }
}
