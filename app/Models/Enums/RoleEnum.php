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
            self::Admin => 2,
            self::Customer => 3,
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
     * Mendapatkan prefix panel berdasarkan peran
     *
     * @return string
     */
    public function getPanelPrefix(): ?string
    {
        return match ($this) {
            self::SuperAdmin => 'superadmin',
            self::Admin => 'admin',
            self::Customer => 'customer', // Contoh: jika ada panel khusus customer
            self::SamplingTechnician => 'sampling-technician', // Contoh: Mungkin tidak punya panel khusus
            self::Analyst => 'analyst',            // Contoh: Mungkin tidak punya panel khusus
            self::TechnicalManager => 'technical-manager', // Contoh: Jika ada panel 'technical'
            self::LaboratoryHead => 'laboratory-head',  // Contoh: Jika ada panel 'laboratory'
        };
    }
}
