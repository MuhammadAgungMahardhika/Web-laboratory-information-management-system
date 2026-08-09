<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum JobStatusEnum: int
{

    case Draft = 1;
    case Sampling = 2;
    case SamplingCompleted = 3;
    case AnalysisCompleted = 4;
    case JobCompleted = 5;
    case Invoiced = 8;
    case Paid = 9;
    case Cancelled = 10;
    case OnHold = 11;


    /**
     * Menyediakan label yang mudah dibaca untuk setiap status pekerjaan.
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Draft->value => 'Draft',
            self::Sampling->value => 'Proses Sampling',
            self::SamplingCompleted->value => 'Proses Analisis',
            self::AnalysisCompleted->value => 'Selesai Analisis',
            self::JobCompleted->value => 'Selesai Job',
            self::Invoiced->value => 'Proses Tagihan',
            self::Paid->value => 'Lunas',
            self::Cancelled->value => 'Dibatalkan',
            self::OnHold->value => 'Ditunda',
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
     * Menyediakan warna visual untuk status pekerjaan (untuk Filament).
     *
     * @param int $status
     * @return string
     */
    public static function color(int $status): string
    {
        return match ($status) {
            self::Draft->value => 'gray',          // Draf
            self::Sampling->value => 'warning',         // Proses Sampling
            self::SamplingCompleted->value => 'info',     // Proses Analisis
            self::AnalysisCompleted->value => 'primary',  // Selesai Analisis
            self::JobCompleted->value => 'success',       // Selesai Job
            self::Invoiced->value => 'warning',           // Proses Tagihan
            self::Paid->value => 'success',               // Lunas
            self::Cancelled->value => 'danger',           // Dibatalkan
            self::OnHold->value => 'gray',                // Ditunda
            default => 'gray',
        };
    }

    /**
     * Menyediakan kode warna CSS (heksadesimal) untuk styling kustom.
     *
     * @param int $status
     * @return string
     */
    public static function cssColor(int $status): string
    {
        return match ($status) {
            self::Draft->value => '#6B7280',        // Draf
            self::Sampling->value => '#F59E0B',          // Proses Sampling
            self::SamplingCompleted->value => '#3B82F6',   // Proses Analisis
            self::AnalysisCompleted->value => '#8B5CF6',   // Selesai Analisis
            self::JobCompleted->value => '#10B981',        // Selesai Job
            self::Invoiced->value => '#F97316',            // Proses Tagihan
            self::Paid->value => '#059669',                // Lunas
            self::Cancelled->value => '#EF4444',           // Dibatalkan
            self::OnHold->value => '#64748B',              // Ditunda
            default => '#6B7280',
        };
    }

    /**
     * Mendapatkan status default untuk pekerjaan baru.
     *
     * @return self
     */
    public static function default(): self
    {
        return self::Draft;
    }
}
