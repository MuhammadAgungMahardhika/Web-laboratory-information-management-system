<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Impor facade PDF dari DomPDF

class QuotationPdfController extends Controller
{
    public function generate(Quotation $quotation)
    {
        // Muat relasi yang dibutuhkan agar data tersedia di Blade view
        $quotation->load(['customer', 'personel', 'quotationItems.parameterQuotationItems']);
        // Perhatikan: 'items' diganti 'quotationItems', dan 'parameters' diganti 'parameterQuotationItems'

        // Kirim data quotation ke Blade view
        $pdf = Pdf::loadView('pdfs.quotation', compact('quotation'));

        // Anda bisa memilih salah satu:
        // 1. Mendownload PDF langsung
        return $pdf->download('Penawaran-' . $quotation->quotation_number . '.pdf');

        // 2. Menampilkan PDF di browser (stream)
        // return $pdf->stream('Penawaran-' . $quotation->quotation_number . '.pdf');
    }
}
