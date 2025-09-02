<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum PositionEnum: string
{
    case Administrator = 'Administrator';
    case Ppc = 'Ppc';
    case KepalaPpc = 'Kepala Ppc';
    case Analyst = 'Analis Laboratorium';
    case TechnicalManager = 'Manajer Teknis';
    case LaboratoryHead = 'Kepala Laboratorium';
    case Manager = 'Manajer Laboratorium';
    case SamplingTechnician = 'Petugas Sampling';
    // 
    /**
     * Menyediakan label untuk setiap status posisi.
     *
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            self::Administrator->value => 'Administrator',
            self::Ppc->value => 'PPC',
            self::KepalaPpc->value => 'Kepala PPC',
            self::Analyst->value => 'Analis Laboratorium',
            self::TechnicalManager->value => 'Manager Teknis',
            self::LaboratoryHead->value => 'Kepala Laboratorium',
            self::Manager->value => 'Manajer Laboratorium',
            self::SamplingTechnician->value => 'Petugas Sampling',
        ];
    }

    /**
     * Mendapatkan label dari status posisi.
     *
     * @return string
     */
    public function label(): string
    {
        return self::labels()[$this->value];
    }

    /**
     * Mengembalikan daftar semua status posisi dalam format array untuk dropdown.
     *
     * @return array<string, string>
     */
    public static function toAssociativeArray(): array
    {
        $positions = [];
        foreach (self::cases() as $case) {
            $positions[$case->value] = $case->label();
        }
        return $positions;
    }

    /**
     * Mendapatkan status default untuk posisi.
     *
     * @return self
     */
    public static function default(): self
    {
        return self::Analyst;
    }

    /**
     * Menyediakan warna visual untuk status posisi.
     *
     * @param string $status
     * @return string
     */
    public static function color(string $status): string
    {
        return match ($status) {
            self::Administrator->value => 'primary',
            self::Ppc->value => 'info',
            self::KepalaPpc->value => 'success',
            self::Analyst->value => 'info',
            self::TechnicalManager->value => 'warning',
            self::LaboratoryHead->value => 'danger',
            self::Manager->value => 'warning',
            self::SamplingTechnician->value => 'gray',
            default => 'gray',
        };
    }

    /**
     * Menyediakan kode warna CSS (heksadesimal) untuk styling kustom.
     *
     * @param string $status
     * @return string
     */
    public static function cssColor(string $status): string
    {
        return match ($status) {
            self::Administrator->value => '#6366F1',
            self::Ppc->value => '#3B82F6',
            self::KepalaPpc->value => '#10B981',
            self::Analyst->value => '#3B82F6',
            self::TechnicalManager->value => '#F59E0B',
            self::LaboratoryHead->value => '#EF4444',
            self::Manager->value => '#F59E0B',
            self::SamplingTechnician->value => '#6B7280',
            default => '#6B7280',
        };
    }
}
