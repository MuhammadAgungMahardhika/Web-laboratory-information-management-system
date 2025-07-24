<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Impor facade PDF dari DomPDF

class QuotationPdfController extends Controller
{
    public function generate(Quotation $quotation)
    {
        // Muat relasi yang dibutuhkan
        $quotation->load(['customer', 'personel', 'quotationItems.parameterQuotationItems']);

        // Buat PDF dari Blade view
        $pdf = Pdf::loadView('pdfs.quotation', compact('quotation'));

        // --- PERBAIKAN DI SINI: Sanitasi Nama File ---
        // Ganti karakter-karakter yang tidak diizinkan dalam nama file dengan tanda hubung (-)
        // Karakter umum yang tidak diizinkan: / \ : * ? " < > |
        $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $quotation->quotation_number);

        // Opsi yang lebih agresif: Hapus semua karakter yang bukan alfanumerik atau tanda hubung/spasi,
        // lalu ganti spasi dengan underscore (jika diinginkan)
        // $safeFileName = preg_replace('/[^a-zA-Z0-9\s-]/', '', $quotation->quotation_number);
        // $safeFileName = str_replace(' ', '_', $safeFileName);

        // Unduh PDF dengan nama file yang sudah disanitasi
        return $pdf->download('Penawaran-' . $safeFileName . '.pdf');

        // Atau untuk menampilkan di browser:
        // return $pdf->stream('Penawaran-' . $safeFileName . '.pdf');
    }
}
