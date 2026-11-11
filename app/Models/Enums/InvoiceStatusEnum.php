<?php

namespace App\Models\Enums;

use Filament\Support\Colors\Color;

enum InvoiceStatusEnum: int
{
    case Draft = 1;
    case Sent = 2;
    case PartiallyPaid = 3;
    case Paid = 4;
    case Overdue = 5;
    case Void = 6;

    /**
     * Menyediakan label yang mudah dibaca untuk setiap status faktur.
     *
     * @return array<int, string>
     */
    public static function labels(): array
    {
        return [
            self::Draft->value         => 'Draft',
            self::Sent->value          => 'Terkirim',
            self::PartiallyPaid->value => 'Dibayar Sebagian', // Label
            self::Paid->value          => 'Lunas',
            self::Overdue->value       => 'Jatuh Tempo',
            self::Void->value          => 'Batal Permanen',
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
     * Menyediakan warna visual untuk status faktur (untuk Filament).
     *
     * @param int $status
     * @return string
     */
    public static function color(int $status): string
    {
        return match ($status)
        {
            self::Draft->value => 'gray',             // Draft
            self::Sent->value => 'info',              // Terkirim
            self::PartiallyPaid->value => 'warning',  // Dibayar Sebagian
            self::Paid->value => 'success',           // Lunas
            self::Overdue->value => 'danger',         // Jatuh Tempo
            self::Void->value => 'gray',              // Batal Permanen
            default => 'gray',
        };
    }

    /**
     * Menyediakan kode warna CSS heksadesimal untuk styling kustom.
     *
     * @param int $status
     * @return string
     */
    public static function cssColor(int $status): string
    {
        return match ($status)
        {
            self::Draft->value => '#6B7280',            // Abu-abu
            self::Sent->value => '#3B82F6',             // Biru
            self::PartiallyPaid->value => '#F59E0B',    // Kuning/Oranye
            self::Paid->value => '#10B981',             // Hijau
            self::Overdue->value => '#EF4444',          // Merah
            self::Void->value => '#64748B',             // Slate
            default => '#6B7280',
        };
    }
    /**
     * Mendapatkan status default untuk faktur baru.
     *
     * @return self
     */
    public static function default(): self
    {
        return self::Draft;
    }

    /**
     * Status final: tagihan tidak lagi punya keterlambatan.
     */
    public function isClosed(): bool
    {
        return in_array($this, [self::Paid, self::Void], true);
    }

    /**
     * Apakah invoice ini masih relevan dihitung keterlambatannya.
     */
    public static function isClosedValue(mixed $status): bool
    {
        $enum = self::tryFrom((int) $status);

        return $enum?->isClosed() ?? false;
    }
}
