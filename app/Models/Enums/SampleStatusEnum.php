<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum SampleStatusEnum: int
{
    case Received = 1;
    case Prepared = 2;
    case AnalysisCompleted = 3;
    case Invalid = 4;
    case Archived = 5;


    /**
     * Menyediakan label untuk setiap status peran
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
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

    public static function default(): self
    {
        return self::Received; // Status default adalah "Pending"
    }
    public static function color(int $status): string
    {
        return match ($status) {
            self::Received->value => 'info',
            self::Prepared->value => 'warning',
            self::AnalysisCompleted->value => 'success',
            self::Invalid->value => 'danger',
            self::Archived->value => 'gray',
            default => 'gray',
        };
    }
}
