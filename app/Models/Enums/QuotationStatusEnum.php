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
            self::Draft->value => 'Draf',
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
        // Handle null input gracefully for robustness, similar to ParameterStatusEnum
        if ($status === null) {
            return 'gray'; // Default color for null status
        }

        switch ($status) {
            case self::Draft->value:
                return 'gray';    // Drafts are often neutral/gray
            case self::Submitted->value:
                return 'warning'; // Pending needs attention
            case self::Accepted->value:
                return 'success'; // Successfully accepted
            case self::Revised->value:
                return 'info';    // Revised implies ongoing process
            case self::Rejected->value:
                return 'danger';  // Rejected is a negative outcome
            case self::Expired->value:
                return 'danger';  // Expired is also a negative/final state
            case self::Cancelled->value:
                return 'danger';    // Cancelled is a neutral/final state
            default:
                return 'gray'; // Fallback for any unexpected status string
        }
    }


    /**
     * Provides a CSS hex color code for inline styling.
     *
     * @param int|null $status The string value of the status.
     * @return string The CSS hex color code.
     */
    public static function cssColor(int $status): string
    {
        if ($status === null) {
            return '#6B7280'; // Default gray
        }

        return match ($status) {
            self::Draft->value => '#6B7280', // Gray
            self::Submitted->value => '#F59E0B', // Orange (warning)
            self::Accepted->value => '#10B981', // Green (success)
            self::Rejected->value => '#EF4444', // Red (danger)
            self::Revised->value => '#3B82F6', // Blue (info)
            self::Expired->value => '#EF4444', // Red (danger)
            self::Cancelled->value => '#6B7280', // Gray
            default => '#6B7280', // Fallback
        };
    }
}
