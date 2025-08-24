<?php

namespace App\Policies;

use App\Models\Enums\QuotationStatusEnum;
use App\Models\Quotation;
use App\Models\User;
use App\Traits\HasPolicyAuthorization;
use Illuminate\Auth\Access\Response;

class QuotationPolicy
{
    use HasPolicyAuthorization;

    public function update(User $user, Quotation $quotation): bool
    {
        // Panggil izin dasar dari trait, lalu tambahkan kondisi khusus
        return static::hasPermission('update', static::getResourceName()) &&  in_array($quotation->status, [
            QuotationStatusEnum::Draft->value,
            QuotationStatusEnum::Submitted->value,
            QuotationStatusEnum::Revised->value,
        ]);
    }
    public function delete(User $user, Quotation $quotation): bool
    {
        // Panggil izin dasar dari trait, lalu tambahkan kondisi khusus
        return static::hasPermission('delete', static::getResourceName()) && in_array($quotation->status, [
            QuotationStatusEnum::Draft->value,
            QuotationStatusEnum::Submitted->value,
            QuotationStatusEnum::Revised->value,
        ]);
    }
}
