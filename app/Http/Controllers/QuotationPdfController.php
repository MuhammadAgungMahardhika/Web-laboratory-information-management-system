<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Impor facade PDF dari DomPDF
use Illuminate\Support\Facades\Auth;

class QuotationPdfController extends Controller
{
    // ...
    public function preview(Quotation $quotation) // Metode untuk preview
    {
        $company = Auth::user()?->personel?->company;
        $quotation->load([
            'quotationItems' => function ($query) {
                $query->orderBy('group', 'asc');
            },
            'quotationItems.parameterQuotationItems',
            'customer',
            'personel'
        ]);
        // --------------------------------------------------------
        $pdf = Pdf::loadView('pdfs.quotation', compact('quotation', 'company'));
        $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $quotation->code);
        return $pdf->stream('Penawaran-' . $safeFileName . '.pdf');
    }

    public function download(Quotation $quotation) // Metode untuk download
    {
        $company = Auth::user()?->personel?->company;
        $quotation->load([
            'quotationItems' => function ($query) {
                $query->orderBy('group', 'asc');
            },
            'quotationItems.parameterQuotationItems',
            'customer',
            'personel'
        ]);
        $pdf = Pdf::loadView('pdfs.quotation', compact('quotation', 'company'));
        $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $quotation->code);
        return $pdf->download('Penawaran-' . $safeFileName . '.pdf');
    }
}
