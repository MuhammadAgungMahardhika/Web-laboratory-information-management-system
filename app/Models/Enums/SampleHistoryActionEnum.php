<?php

namespace App\Models\Enums;

enum SampleHistoryActionEnum: int
{
    case Created = 1;
    case Received = 2;
    case Prepared = 3;
    case AnalysisCompleted = 4;
    case Invalid = 5;
    case Archived = 6;
    case Updated = 7;

    public static function labels(): array
    {
        return [
            self::Created->value => 'Dibuat',
            self::Received->value => 'Diterima',
            self::Prepared->value => 'Proses Analisis',
            self::AnalysisCompleted->value => 'Selesai Analisis',
            self::Invalid->value => 'Tidak Valid',
            self::Archived->value => 'Diarsipkan',
            self::Updated->value => 'Diperbarui',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value];
    }

    public static function color(int $action): string
    {
        return match ($action) {
            self::Created->value => 'gray',
            self::Received->value => 'info',
            self::Prepared->value => 'warning',
            self::AnalysisCompleted->value => 'success',
            self::Invalid->value => 'danger',
            self::Archived->value => 'primary',
            self::Updated->value => 'gray',
            default => 'gray',
        };
    }

    public static function cssColor(int $action): string
    {
        return match ($action) {
            self::Created->value => '#6B7280',
            self::Received->value => '#3B82F6',
            self::Prepared->value => '#F59E0B',
            self::AnalysisCompleted->value => '#10B981',
            self::Invalid->value => '#EF4444',
            self::Archived->value => '#8B5CF6',
            self::Updated->value => '#6B7280',
            default => '#6B7280',
        };
    }
}
