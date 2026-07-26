<?php

namespace App\Models\Enums;

enum TestResultApprovalStatusEnum: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Revision = 'revision';
    case Revoked = 'revoked';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Accepted => 'Disetujui',
            self::Rejected => 'Ditolak',
            self::Revision => 'Revisi',
            self::Revoked => 'Revoke',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => '#ca8a04',
            self::Accepted => '#16a34a',
            self::Rejected => '#dc2626',
            self::Revision => '#ea580c',
            self::Revoked   => '#6b7280', // Gray
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Pending => '⏳',
            self::Accepted => '✓',
            self::Rejected => '✕',
            self::Revision  => '📝',
            self::Revoked   => '🔄',
        };
    }
}
