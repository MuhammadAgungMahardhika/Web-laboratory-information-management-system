<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum JobStatusEnum: string
{
    case PendingStart = 'pending_start';
    case InProgress = 'in_progress';
    case SamplingCompleted = 'sampling_completed';
    case AnalysisCompleted = 'analysis_completed';
    case ValidationCompleted = 'validation_completed';
    case ReportGenerated = 'report_generated';
    case ReportApproved = 'report_approved';
    case Invoiced = 'invoiced';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
    case OnHold = 'on_hold';

    /**
     * Menyediakan label yang mudah dibaca untuk setiap status pekerjaan.
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::PendingStart->value => 'Menunggu Mulai',
            self::InProgress->value => 'Dalam Proses',
            self::SamplingCompleted->value => 'Sampling Selesai',
            self::AnalysisCompleted->value => 'Analisis Selesai',
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
     * @param string $status
     * @return string
     */
    public static function color(string $status): string
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
     * @param string $status
     * @return string
     */
    public static function cssColor(string $status): string
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
