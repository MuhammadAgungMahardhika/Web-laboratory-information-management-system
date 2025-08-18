<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum SampleStatusEnum: string
{
    case Received = 'received';
    case Prepared = 'prepared';
    case InAnalysis = 'in_analysis';
    case AnalysisCompleted = 'analysis_completed';
    case Invalid = 'invalid';
    case Archived = 'archived';


    /**
     * Menyediakan label untuk setiap status peran
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Received->value => 'Diterima',
            self::Prepared->value  => 'Disiapkan',
            self::InAnalysis->value  => 'Dalam Analisis',
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
    public static function color(string $status): string
    {
        return match ($status) {
            self::Received->value => 'info',
            self::Prepared->value => 'warning',
            self::InAnalysis->value => 'primary',
            self::AnalysisCompleted->value => 'success',
            self::Invalid->value => 'danger',
            self::Archived->value => 'gray',
            default => 'gray',
        };
    }
}
