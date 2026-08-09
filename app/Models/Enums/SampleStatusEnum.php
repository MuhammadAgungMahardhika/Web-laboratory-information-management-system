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
            self::Prepared->value  => 'Proses Analisis',
            self::AnalysisCompleted->value  => 'Selesai Analisis',
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
            self::Collected->value => 'gray',       // Diambil
            self::Received->value => 'info',        // Diterima
            self::Prepared->value => 'warning',     // Proses Analisis
            self::AnalysisCompleted->value => 'success', // Selesai Analisis
            self::Invalid->value => 'danger',       // Tidak Valid
            self::Archived->value => 'primary',     // Diarsipkan
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
            self::Collected->value => '#6B7280',          // Abu-abu - Diambil
            self::Received->value => '#3B82F6',           // Biru - Diterima
            self::Prepared->value => '#F59E0B',           // Oranye - Proses Analisis
            self::AnalysisCompleted->value => '#10B981',  // Hijau - Selesai Analisis
            self::Invalid->value => '#EF4444',             // Merah - Tidak Valid
            self::Archived->value => '#8B5CF6',            // Ungu - Diarsipkan
            default => '#6B7280',
        };
    }
}
