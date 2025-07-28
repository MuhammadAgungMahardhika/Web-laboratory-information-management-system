<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color; // Assuming you're using Filament's Color class for consistency, otherwise return simple strings like 'success', 'danger'

enum QuotationStatusEnum: string
{
    case Draft = 'draft';
    case PendingResponse = 'pending_response';
    case Accepted = 'accepted';
    case Revised = 'revised';
    case Expired = 'expired';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    /**
     * Provides a human-readable label for each quotation status.
     *
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            self::Draft->value => 'Draf',
            self::PendingResponse->value => 'Menunggu Respon',
            self::Accepted->value => 'Diterima',
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
     * @param string|null $status The string value of the status.
     * @return string The color name (e.g., 'success', 'danger', 'info').
     */
    public static function color(?string $status): string
    {
        // Handle null input gracefully for robustness, similar to ParameterStatusEnum
        if ($status === null) {
            return 'gray'; // Default color for null status
        }

        switch ($status) {
            case self::Draft->value:
                return 'gray';    // Drafts are often neutral/gray
            case self::PendingResponse->value:
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
     * @param string|null $status The string value of the status.
     * @return string The CSS hex color code.
     */
    public static function cssColor(?string $status): string
    {
        if ($status === null) {
            return '#6B7280'; // Default gray
        }

        return match ($status) {
            self::Draft->value => '#6B7280', // Gray
            self::Accepted->value => '#F59E0B', // Orange (warning)
            self::Accepted->value => '#10B981', // Green (success)
            self::Rejected->value => '#EF4444', // Red (danger)
            self::Revised->value => '#3B82F6', // Blue (info)
            self::Expired->value => '#EF4444', // Red (danger)
            self::Cancelled->value => '#6B7280', // Gray
            default => '#6B7280', // Fallback
        };
    }
}
