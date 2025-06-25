<?php
// app/Enums/PaymentStatusEnum.php

namespace App\Models\Enums;

enum RoleStatusEnum: string
{
    case Superadmin = 'superadmin';
    case Admin = 'admin';
    case Customer = 'customer';


    public function id(): int
    {
        return match ($this) {
            self::Superadmin => 1,
            self::Admin => 2,
            self::Customer => 3,
        };
    }
    /**
     * Menyediakan label untuk setiap status peran
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Superadmin->value => 'superadmin',
            self::Admin->value => 'admin',
            self::Customer->value => 'pelanggan',

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
        return self::Customer; // Status default adalah "Pending"
    }

    /**
     * Mendapatkan prefix panel berdasarkan peran
     *
     * @return string
     */
    public function getPanelPrefix(): string
    {
        return match ($this) {
            self::Superadmin => 'superadmin',
            self::Admin => 'admin',
            self::Customer => 'customer',
        };
    }
}
