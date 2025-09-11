<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum TestResultEvaluationStatusEnum: int
{
    case Compliant = 1;        // Sesuai baku mutu
    case BelowStandard = 2; // Nilai < min
    case AboveStandard = 3; // Nilai > max
    case NotApplicable = 4; // Tidak ada standar
    case Invalid = 5;            // Data tidak sah

    public static function labels(): array
    {
        return [
            self::Compliant->value => 'Sesuai Baku Mutu',
            self::BelowStandard->value => 'Dibawah Baku Mutu',
            self::AboveStandard->value => 'Diatas Baku Mutu',
            self::NotApplicable->value => 'Tidak ada standar',
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
            self::BelowStandard->value => 'warning',
            self::AboveStandard->value => 'warning',
            self::NotApplicable->value => 'gray',
            self::Invalid->value => 'danger',
            default => 'gray',
        };
    }
}
