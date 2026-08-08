<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum JobStatusEnum: int
{

    case PendingStart = 1;
    case InProgress = 2;
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
            self::PendingStart->value => 'Draf',
            self::InProgress->value => 'Proses Sampling',
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
            self::PendingStart->value, self::OnHold->value => 'gray',
            self::InProgress->value, self::Invoiced->value  => 'warning',
            self::SamplingCompleted->value, self::AnalysisCompleted->value => 'info',
            self::JobCompleted->value => 'success',
            self::Paid->value => 'success',
            self::Cancelled->value => 'danger',
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
            self::PendingStart->value, self::OnHold->value => '#6B7280',
            self::InProgress->value => '#F59E0B',
            self::SamplingCompleted->value, self::AnalysisCompleted->value,  => '#3B82F6',
            self::JobCompleted->value, self::Paid->value => '#10B981',
            self::Cancelled->value => '#EF4444',
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
        return self::PendingStart;
    }
}
