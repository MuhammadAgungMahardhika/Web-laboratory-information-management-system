<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum TestResultEvaluationStatusEnum: int
{
    case Compliant = 1;        // Sesuai baku mutu
    case Invalid = 2; // Nilai < min

    public static function labels(): array
    {
        return [
            self::Compliant->value => 'Sesuai Baku Mutu',
            self::Invalid->value => 'Tidak Sesuai Baku Mutu',
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

    public static function cssColor(?int $status): string
    {
        return match ($status) {
            self::Compliant->value => '#10B981', // Green
            self::Invalid->value => '#EF4444',   // Red
            default => '#6B7280',                // Gray
        };
    }
}
