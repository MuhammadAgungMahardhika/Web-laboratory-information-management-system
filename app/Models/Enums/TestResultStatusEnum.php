<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum TestResultStatusEnum: int
{
    case Raw = 1;
    case RequestValidate = 2;
    case Validated = 3;
    case RevisionNeeded = 4;
    case Rejected = 5;

    public static function labels(): array
    {
        return [
            self::Raw->value => 'Draft',
            self::RequestValidate->value => 'Pengajuan',
            self::Validated->value => 'Tervalidasi',
            self::RevisionNeeded->value => 'Perlu Revisi',
            self::Rejected->value => 'Ditolak',
        ];
    }

    /**
     * Gets the human-readable label for the current enum case.
     *
     * @return string
     */
    public function label(): string
    {
        return self::labels()[$this->value];
    }

    public static function color(int $status): string
    {
        return match ($status) {
            self::Raw->value => 'gray',                // Data awal
            self::RequestValidate->value => 'warning', // Menunggu validasi
            self::Validated->value => 'success',        // Sudah divalidasi
            self::RevisionNeeded->value => 'warning',   // Perlu revisi
            self::Rejected->value => 'danger',          // Ditolak
            default => 'gray',
        };
    }

    /**
     * Provides a CSS hex color code for inline styling.
     *
     * @param int|null $status The status value.
     * @return string The CSS hex color code.
     */
    public static function cssColor(int $status): string
    {
        return match ($status) {
            self::Raw->value => '#6B7280',                // Abu-abu
            self::RequestValidate->value => '#F59E0B',    // Kuning/oranye
            self::Validated->value => '#10B981',          // Hijau
            self::RevisionNeeded->value => '#F97316',     // Oranye tua
            self::Rejected->value => '#EF4444',           // Merah
            default => '#6B7280',
        };
    }
}
