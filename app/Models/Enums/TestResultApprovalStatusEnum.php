<?php

namespace App\Models\Enums;

enum TestResultApprovalStatusEnum: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Revision = 'revision';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Accepted => 'Disetujui',
            self::Rejected => 'Ditolak',
            self::Revision => 'Revisi',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => '#ca8a04',
            self::Accepted => '#16a34a',
            self::Rejected => '#dc2626',
            self::Revision => '#ea580c',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Pending => '⏳',
            self::Accepted => '✓',
            self::Rejected => '✕',
            self::Revision => '↺',
        };
    }
}
