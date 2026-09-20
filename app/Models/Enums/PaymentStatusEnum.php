<?php

namespace App\Models\Enums;

enum PaymentStatusEnum: int
{
    case Pending = 1;
    case Completed = 2;
    case Cancelled = 3;

    /**
     * Menyediakan label yang mudah dibaca untuk setiap status pembayaran.
     *
     * @return array<int, string>
     */
    public static function labels(): array
    {
        return [
            self::Pending->value   => 'Draft',
            self::Completed->value => 'Selesai',
            self::Cancelled->value => 'Batal',
        ];
    }

    /**
     * Mendapatkan label untuk status pembayaran saat ini.
     */
    public function label(): string
    {
        return self::labels()[$this->value];
    }

    /**
     * Menyediakan warna visual untuk status pembayaran (untuk Filament).
     */
    public static function color(int $status): string
    {
        return match ($status) {
            self::Pending->value   => 'gray',
            self::Completed->value => 'success',
            self::Cancelled->value => 'danger',
            default                => 'gray',
        };
    }

    /**
     * Menyediakan kode warna CSS heksadesimal untuk styling kustom.
     */
    public static function cssColor(int $status): string
    {
        return match ($status) {
            self::Pending->value   => '#6B7280', // Kuning/Oranye
            self::Completed->value => '#10B981', // Hijau
            self::Cancelled->value => '#EF4444', // Slate
            default                => '#6B7280',  // Abu-abu
        };
    }

    /**
     * Mendapatkan status default untuk pembayaran baru.
     */
    public static function default(): self
    {
        return self::Pending;
    }
}
