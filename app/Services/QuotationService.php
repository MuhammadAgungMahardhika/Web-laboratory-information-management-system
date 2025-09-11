<?php

namespace App\Services;

use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\QuotationStatusEnum;
use App\Models\LabJob;
use App\Models\Quotation;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

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

    /**
     * Mengubah status penawaran dan memicu aksi terkait.
     *
     * @param Quotation $quotation
     * @param QuotationStatusEnum $newStatus
     * @return bool
     */
    public function updateQuotationStatus(Quotation $quotation, QuotationStatusEnum $newStatus): bool
    {
        // 1. Perbarui status penawaran
        $quotation->status = $newStatus->value;

        if ($newStatus === QuotationStatusEnum::Submitted) {
            if (count($quotation->quotationItems) == 0) {
                throw new Exception('Detail penawaran belum terisi');
            }
        }
        // 2. Lakukan aksi spesifik berdasarkan status baru
        if ($newStatus === QuotationStatusEnum::Accepted) {
            // Logika untuk membuat Lab Job saat penawaran diterima
            $labJobService = new LabJobService();
            $labJobService->createLabJobFromQuotation($quotation);
        }

        // 3. Simpan perubahan ke database
        return $quotation->save();
    }
}
