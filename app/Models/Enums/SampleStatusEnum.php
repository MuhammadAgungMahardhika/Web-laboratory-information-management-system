<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum SampleStatusEnum: int
{
    case Collected = 1;
    case Received = 2;
    case Prepared = 3;
    case AnalysisCompleted = 4;
    case Invalid = 5;
    case Archived = 6;


    /**
     * Menyediakan label untuk setiap status peran
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Collected->value => 'Diambil',
            self::Received->value => 'Diterima',
            self::Prepared->value  => 'Siap dianalisa',
            self::AnalysisCompleted->value  => 'Analisis Selesai',
            self::Invalid->value  => 'Tidak Valid',
            self::Archived->value  => 'Diarsipkan',
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

    public static function default(): int
    {
        return self::Collected->value; // Status default adalah "Pending"
    }
    public static function color(int $status): string
    {
        return match ($status) {
            self::Collected->value => 'info',
            self::Received->value => 'info',
            self::Prepared->value => 'warning',
            self::AnalysisCompleted->value => 'success',
            self::Invalid->value => 'danger',
            self::Archived->value => 'gray',
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
        if ($status === null) {
            return '#6B7280'; // Default gray
        }

        return match ($status) {
            self::Collected->value => '#6B7280',
            self::Received->value => '#10B981',
            self::Prepared->value => '#F59E0B',
            self::AnalysisCompleted->value =>  '#10B981',
            self::Invalid->value => '#EF4444',
            self::Archived->value => '#6B7280',
            default => '#6B7280', // Fallback
        };
    }
}
