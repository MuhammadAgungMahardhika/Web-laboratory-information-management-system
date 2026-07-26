<?php
// app/Enums/PaymentStatusEnum.php

namespace App\Models\Enums;

enum UserStatusEnum: int
{
    case Active = 1;
    case Inactive = 2;

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
    public static function color(int $status): string
    {
        switch ($status) {
            case self::Active->value:
                return 'success';

            case self::Inactive->value:
                return 'danger';

            default:
                return 'info';
        }
    }
}
