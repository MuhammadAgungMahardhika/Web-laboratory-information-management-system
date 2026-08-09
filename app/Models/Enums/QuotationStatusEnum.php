<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color; // Assuming you're using Filament's Color class for consistency, otherwise return simple strings like 'success', 'danger'

enum QuotationStatusEnum: int
{
    case Draft = 1;
    case Submitted = 2;
    case Accepted = 3;
    case Revised = 4;
    case Expired = 5;
    case Rejected = 6;
    case Cancelled = 7;


    /**
     * Provides a human-readable label for each quotation status.
     *
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            self::Draft->value => 'Draft',
            self::Submitted->value => 'Dikirim',
            self::Accepted->value => 'Disetujui',
            self::Revised->value => 'Direvisi',
            self::Expired->value => 'Kadaluarsa',
            self::Rejected->value => 'Ditolak',
            self::Cancelled->value => 'Dibatalkan',
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

    /**
     * Provides a default status for new quotations.
     *
     * @return self
     */
    public static function default(): self
    {
        return self::Draft;
    }

    /**
     * Provides a color hint for Filament badges/status displays.
     *
     * @param int|null $status The string value of the status.
     * @return string The color name (e.g., 'success', 'danger', 'info').
     */
    public static function color(int $status): string
    {
        return match ($status) {
            self::Draft->value => 'gray',          // Draf
            self::Submitted->value => 'warning',   // Dikirim / menunggu respons
            self::Accepted->value => 'success',    // Disetujui
            self::Revised->value => 'info',        // Direvisi
            self::Expired->value => 'warning',     // Kadaluarsa
            self::Rejected->value => 'danger',     // Ditolak
            self::Cancelled->value => 'gray',      // Dibatalkan
            default => 'gray',
        };
    }


    /**
     * Provides a CSS hex color code for inline styling.
     *
     * @param int|null $status The string value of the status.
     * @return string The CSS hex color code.
     */
    public static function cssColor(int $status): string
    {
        return match ($status) {
            self::Draft->value => '#6B7280',       // Abu-abu - Draf
            self::Submitted->value => '#F59E0B',   // Kuning - Dikirim
            self::Accepted->value => '#10B981',    // Hijau - Disetujui
            self::Revised->value => '#3B82F6',     // Biru - Direvisi
            self::Expired->value => '#F97316',     // Oranye - Kadaluarsa
            self::Rejected->value => '#EF4444',    // Merah - Ditolak
            self::Cancelled->value => '#64748B',   // Slate - Dibatalkan
            default => '#6B7280',
        };
    }
}
