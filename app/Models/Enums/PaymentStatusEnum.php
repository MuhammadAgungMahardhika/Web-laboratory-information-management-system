<?php

namespace App\Models\Enums;

enum PaymentStatusEnum: int
{
    case Pending = 1;
    case Completed = 2;
    case Failed = 3;
    case Cancelled = 4;

    /**
     * Menyediakan label yang mudah dibaca untuk setiap status pembayaran.
     *
     * @return array<int, string>
     */
    public static function labels(): array
    {
        return [
            self::Pending->value   => 'Draft',
            self::Completed->value => 'Berhasil',
            self::Failed->value    => 'Gagal',
            self::Cancelled->value => 'Dibatalkan',
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
            self::Pending->value   => 'warning',
            self::Completed->value => 'success',
            self::Failed->value    => 'danger',
            self::Cancelled->value => 'gray',
            default                => 'gray',
        };
    }

    /**
     * Menyediakan kode warna CSS heksadesimal untuk styling kustom.
     */
    public static function cssColor(int $status): string
    {
        return match ($status) {
            self::Pending->value   => '#F59E0B', // Kuning/Oranye
            self::Completed->value => '#10B981', // Hijau
            self::Failed->value    => '#EF4444', // Merah
            self::Cancelled->value => '#64748B', // Slate
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
