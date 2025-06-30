<?php

namespace App\Services;

use App\Models\Quotation;
use Carbon\Carbon;

class QuotationService
{
    public function generateQuotationNumber(): string
    {
        $monthRoman = [
            'I',
            'II',
            'III',
            'IV',
            'V',
            'VI',
            'VII',
            'VIII',
            'IX',
            'X',
            'XI',
            'XII'
        ];

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        // Hitung jumlah quotation yang sudah ada di tahun ini (atau sesuaikan per bulan jika ingin reset bulanan)
        $count = Quotation::whereYear('created_at', $year)->count() + 1;

        // Format nomor urut ke 3 digit
        $number = str_pad($count, 3, '0', STR_PAD_LEFT);

        // Gabungkan menjadi format akhir
        return "{$number}/Jalint-Lab/{$monthRoman[$month - 1]}/{$year}";
    }
}
