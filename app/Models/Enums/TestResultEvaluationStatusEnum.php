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
            self::Invalid->value => 'Data Rusak',
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

    public static function color(string $status): string
    {
        return match ($status) {
            self::Compliant->value => 'success',
            self::Invalid->value => 'danger',
            default => 'gray',
        };
    }
}
