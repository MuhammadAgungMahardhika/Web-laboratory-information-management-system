<?php

namespace App\Models\Enums;

enum ParameterStatusEnum: string
{
    case Accredited = 'accredited';
    case Unaccredited = 'unaccredited';

    /**
     * Menyediakan label untuk setiap status akreditasi.
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Accredited->value => 'Terakreditasi',
            self::Unaccredited->value => 'Belum Terakreditasi',
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
     * @param string $status
     * @return string
     */
    public static function color(string $status): string
    {
        switch ($status) {
            case self::Accredited->value:
                return 'success'; // Hijau untuk terakreditasi
            case self::Unaccredited->value:
                return 'danger';  // Merah untuk belum terakreditasi
            default:
                return 'gray';
        }
    }
}
