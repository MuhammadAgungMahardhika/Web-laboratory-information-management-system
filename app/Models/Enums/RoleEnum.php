<?php
// app/Enums/PaymentStatusEnum.php

namespace App\Models\Enums;

enum RoleEnum: string
{
    case SuperAdmin = 'superadmin';
    case Admin = 'admin';
    case Customer = 'customer';
    case SamplingTechnician = 'sampling technician'; // Menggunakan spasi sesuai dengan roles Anda
    case Analyst = 'analyst';
    case TechnicalManager = 'technical manager';   // Menggunakan spasi sesuai dengan roles Anda
    case LaboratoryHead = 'laboratory head';


    public function id(): int
    {
        return match ($this) {
            self::SuperAdmin => 1,
            self::Customer => 2,
            self::Admin => 3,
            self::SamplingTechnician => 4,
            self::Analyst => 5,
            self::TechnicalManager => 6,
            self::LaboratoryHead => 7,
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
            self::SuperAdmin->value => 'Super Admin',
            self::Admin->value => 'Admin',
            self::Customer->value => 'Pelanggan',
            self::SamplingTechnician->value => 'Petugas Sampling',
            self::Analyst->value => 'Analis',
            self::TechnicalManager->value => 'Manager Teknis',
            self::LaboratoryHead->value => 'Kepala Laboratorium',
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
     * Mengembalikan daftar semua role dalam format array untuk dropdown, dll.
     * Key adalah value dari enum, Value adalah labelnya.
     *
     * @return array<string, string>
     */
    public static function toAssociativeArray(): array
    {
        $roles = [];
        foreach (self::cases() as $case) {
            $roles[$case->value] = $case->label();
        }
        return $roles;
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
     * Menentukan apakah sebuah peran adalah peran inti sistem yang tidak boleh diubah/dihapus.
     * Logika ini digunakan oleh RolePolicy.
     *
     * @param string $roleId
     * @return bool
     */
    public static function isCoreSystemRole(int $roleId): bool
    {
        return in_array($roleId, [
            self::SuperAdmin->id(),
            self::Customer->id(),
            self::Analyst->id(),
            self::SamplingTechnician->id(),

        ]);
    }
}
