<?php
// app/Enums/PaymentStatusEnum.php

namespace App\Models\Enums;

enum UserStatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';

    /**
     * Menyediakan label untuk setiap status pembayaran
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Active->value => 'Aktif',
            self::Inactive->value => 'Tidak aktif'
        ];
    }

    /**
     * Mendapatkan label dari status pembayaran
     *
     * @return string
     */
    public function label(): string
    {
        return self::labels()[$this->value];
    }

    /**
     * Mendapatkan default case untuk enum
     *
     * @return self
     */
    public static function default(): self
    {
        return self::Active; // Status default adalah "Pending"
    }
    public static function color($status): string
    {
        switch ($status) {
            case self::Active->value:
                return 'success';
                break;
            case self::Inactive->value:
                return 'danger';
                break;
            default:
                return 'info';
        }
    }
}
