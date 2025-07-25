<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Impor facade PDF dari DomPDF

class QuotationPdfController extends Controller
{
    // ...
    public function preview(Quotation $quotation) // Metode untuk preview
    {

        $pdf = Pdf::loadView('pdfs.quotation', compact('quotation'));
        $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $quotation->quotation_number);
        return $pdf->stream('Penawaran-' . $safeFileName . '.pdf');
    }

    public function download(Quotation $quotation) // Metode untuk download
    {
        $pdf = Pdf::loadView('pdfs.quotation', compact('quotation'));
        $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $quotation->quotation_number);
        return $pdf->download('Penawaran-' . $safeFileName . '.pdf');
    }
}
