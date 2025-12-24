<?php

namespace App\Models\Enums;

enum ParameterStatusEnum: int
{
    case Accredited = 1;
    case Unaccredited = 2;
    case Sub = 3;

    /**
     * Menyediakan label untuk setiap status akreditasi.
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Accredited->value => 'A',
            self::Unaccredited->value => 'NA',
            self::Sub->value => 'S',
        ];
    }

    /**
     * Mendapatkan label dari status akreditasi.
     *
     * @return string
     */
    public function label(): string
    {
        return self::labels()[$this->value];
    }

    /**
     * Mendapatkan default case untuk enum.
     *
     * @return self
     */
    public static function default(): self
    {
        return self::Accredited; // Default status jika tidak ditentukan
    }

    /**
     * Mendapatkan warna visual untuk status akreditasi (contoh untuk Filament).
     *
     * @param int $status
     * @return int
     */
    public static function color(int $status): string
    {
        switch ($status) {
            case self::Accredited->value:
                return 'success'; // Hijau untuk terakreditasi
            case self::Unaccredited->value:
                return 'danger';  // Merah untuk belum terakreditasi
            case self::Sub->value:
                return 'warning';  // Merah untuk belum terakreditasi
            default:
                return 'gray';
        }
    }

    /**
     * Mendapatkan kode warna CSS (heksadesimal) untuk styling kustom.
     *
     * @param int $status
     * @return string
     */
    public static function cssColor(int $status): string
    {
        return match ($status) {
            self::Accredited->value => '#10B981', // Hijau yang sesuai dengan 'success' di Filament
            self::Unaccredited->value => '#EF4444', // Merah yang sesuai dengan 'danger' di Filament
            self::Sub->value => '#efa544ff', // Merah yang sesuai dengan 'danger' di Filament
            default => '#6B7280', // Abu-abu yang sesuai dengan 'gray' di Filament
        };
    }
}
