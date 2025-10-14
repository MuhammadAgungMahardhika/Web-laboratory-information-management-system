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
            self::Draft->value         => 'Draf',
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
        return match ($status) {
            self::Draft->value     => 'gray',
            self::Sent->value      => 'info',
            self::PartiallyPaid->value => 'warning', // Kuning/Oranye untuk menandai masih ada saldo
            self::Paid->value      => 'success',
            self::Overdue->value   => 'danger', // Overdue tetap merah agar mendesak
            self::Void->value, self::Void->value => 'danger',
            default => 'gray',
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
}
