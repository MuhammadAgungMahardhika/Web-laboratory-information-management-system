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


        $currentMonth = Carbon::now()->month; // Ambil bulan saat ini (angka 1-12)
        $currentYear = Carbon::now()->year; // Ambil tahun saat ini
        // Hitung jumlah quotation yang sudah ada di tahun ini (atau sesuaikan per bulan jika ingin reset bulanan)
        $count = Quotation::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count() + 1;

        // Format nomor urut ke 3 digit
        $number = str_pad($count, 3, '0', STR_PAD_LEFT);

        // Gabungkan menjadi format akhir
        return "{$number}/Jalint-Lab/{$monthRoman[$currentMonth - 1]}/{$currentYear}";
    }

    public function createParameterQuotationItems(): array
    {
        return [
            'name' => 'Nama',
            'description' => 'Keterangan',
            'quantity' => 'Jumlah',
            'unit_price' => 'Harga Satuan',
            'total_price' => 'Total Harga',
        ];
    }
}
