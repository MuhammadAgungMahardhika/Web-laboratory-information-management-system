<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum SampleCollectionTypeEnum: int
{
    case Collected = 1;
    case Delivered = 2;

    //3,4,5->empty

    /**
     * Menyediakan label untuk setiap status peran
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Collected->value => 'Sampling',
            self::Delivered->value  => 'Antar',
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

    public static function default(): self
    {
        return self::Collected; // Status default adalah "Pending"
    }
    public static function color(int $status): string
    {
        return match ($status) {
            self::Collected->value => 'info',
            self::Delivered->value => 'warning',
            default => 'gray',
        };
    }
}
