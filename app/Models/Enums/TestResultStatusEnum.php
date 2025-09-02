<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum TestResultStatusEnum: string
{
    case Raw = 'raw';
    case RequestValidate = 'request_validate';
    case Validated = 'validated';
    case RevisionNeeded = 'revision_needed';
    case Rejected = 'rejected';

    public static function labels(): array
    {
        return [
            self::Raw->value => 'Mentah',
            self::RequestValidate->value => 'Request Validasi',
            self::Validated->value => 'Divalidasi',
            self::RevisionNeeded->value => 'Perlu Revisi',
            self::Rejected->value => 'Ditolak',
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

    public static function color(string $status): string
    {
        return match ($status) {
            self::Raw->value => 'gray',
            self::Validated->value => 'success',
            self::RequestValidate->value => 'warning',
            self::RevisionNeeded->value => 'info',
            self::Rejected->value => 'danger',
            default => 'gray',
        };
    }
}
