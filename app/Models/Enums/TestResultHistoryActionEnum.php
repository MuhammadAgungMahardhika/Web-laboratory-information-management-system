<?php

namespace App\Models\Enums;

enum TestResultHistoryActionEnum: int
{
    case Created   = 10;
    case Updated   = 20;
    case Submitted = 30;
    case Approved  = 40;
    case Rejected  = 50;
    case Revision  = 60;
    case Reopened  = 70;

    public function label(): string
    {
        return match ($this) {
            self::Created   => 'Dibuat',
            self::Updated   => 'Diperbarui',
            self::Submitted => 'Pengajuan',
            self::Approved  => 'Disetujui',
            self::Rejected  => 'Ditolak',
            self::Revision  => 'Revisi',
            self::Reopened  => 'Reopen',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Created   => '➕',
            self::Updated   => '✏️',
            self::Submitted => '📤',
            self::Approved  => '✅',
            self::Rejected  => '❌',
            self::Revision  => '📝',
            self::Reopened  => '🔄',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Created   => '#2563eb', // Blue
            self::Updated   => '#6b7280', // Gray
            self::Submitted => '#ca8a04', // Amber
            self::Approved  => '#16a34a', // Green
            self::Rejected  => '#dc2626', // Red
            self::Revision  => '#ea580c', // Orange
            self::Reopened  => '#7c3aed', // Purple
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
