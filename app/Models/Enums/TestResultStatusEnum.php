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
            self::Raw->value => 'Mentah',
            self::RequestValidate->value => 'Request Validasi',
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
            self::Raw->value => 'gray',
            self::Validated->value => 'success',
            self::RequestValidate->value => 'warning',
            self::RevisionNeeded->value => 'info',
            self::Rejected->value => 'danger',
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
            self::Raw->value => '#6B7280',
            self::RequestValidate->value => '#F59E0B',
            self::Validated->value => '#10B981',
            self::RevisionNeeded->value => '#3B82F6',
            self::Rejected->value => '#EF4444',
            default => '#6B7280',
        };
    }
}
