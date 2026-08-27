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

    public function label(): string
    {
        return match ($this) {
            self::Created => 'Dibuat',
            self::Received => 'Diterima',
            self::Prepared => 'Proses Analisis',
            self::AnalysisCompleted => 'Selesai Analisis',
            self::Invalid => 'Tidak Valid',
            self::Archived => 'Diarsipkan',
            self::Updated => 'Diperbarui',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Created => '➕',
            self::Received => '📥',
            self::Prepared => '🔬',
            self::AnalysisCompleted => '✅',
            self::Invalid => '❌',
            self::Archived => '📦',
            self::Updated => '✏️',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Created => '#6B7280',
            self::Received => '#3B82F6',
            self::Prepared => '#F59E0B',
            self::AnalysisCompleted => '#10B981',
            self::Invalid => '#EF4444',
            self::Archived => '#8B5CF6',
            self::Updated => '#6B7280',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }
}
