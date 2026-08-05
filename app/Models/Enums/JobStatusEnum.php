<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum JobStatusEnum: int
{

    case PendingStart = 1;
    case InProgress = 2;
    case SamplingCompleted = 3;
    case AnalysisCompleted = 4;
    case ValidationCompleted = 5;
    case ReportGenerated = 6;
    case ReportApproved = 7;
    case Invoiced = 8;
    case Delivered = 9;
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
            self::PendingStart->value => 'Menunggu Mulai',
            self::InProgress->value => 'Proses Sampling',
            self::SamplingCompleted->value => 'Selesai Sampling',
            self::AnalysisCompleted->value => 'Selesai Analisis',
            self::ValidationCompleted->value => 'Validasi Selesai',
            self::ReportGenerated->value => 'Laporan Dibuat',
            self::ReportApproved->value => 'Laporan Disetujui',
            self::Invoiced->value => 'Telah Ditagih',
            self::Delivered->value => 'Selesai (Terkirim)',
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
            self::InProgress->value => 'warning',
            self::SamplingCompleted->value, self::AnalysisCompleted->value, self::ValidationCompleted->value => 'info',
            self::ReportGenerated->value, self::ReportApproved->value, self::Invoiced->value => 'success',
            self::Delivered->value => 'success',
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
            self::SamplingCompleted->value, self::AnalysisCompleted->value, self::ValidationCompleted->value => '#3B82F6',
            self::ReportGenerated->value, self::ReportApproved->value, self::Invoiced->value => '#10B981',
            self::Delivered->value => '#10B981',
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
