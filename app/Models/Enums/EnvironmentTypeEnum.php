<?php

namespace App\Models\Enums;

enum EnvironmentTypeEnum: string
{
    case Living = 'living';
    case Working = 'working';
    case General = 'general';

    /**
     * Menyediakan label untuk setiap status lingkungan
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::Living->value => 'hidup',
            self::Working->value => 'kerja',
            self::General->value => 'umum',
        ];
    }

    /**
     * Mendapatkan label dari status lingkungan
     *
     * @return string
     */
    public function label(): string
    {
        return self::labels()[$this->value];
    }

    /**
     * Mendapatkan default case untuk enum
     *
     * @return self
     */
    public static function default(): self
    {
        return self::General;
    }

    public static function color(string $status): string
    {
        switch ($status) {
            case self::Living->value:
                return 'success'; // Contoh warna untuk 'hidup'
            case self::Working->value:
                return 'warning'; // Contoh warna untuk 'kerja'
            case self::General->value:
                return 'info';    // Contoh warna untuk 'umum'
            default:
                return 'secondary'; // Warna default jika tidak ada yang cocok
        }
    }
}
