<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoicePdfController extends Controller
{
    public function preview(Invoice $invoice)
    {
        $company = Auth::user()?->personel?->company;

        $invoice->load([
            'invoiceItems',
            'labJob.quotation.customer',
            'labJob.quotation.personel',
        ]);

        $pdf = Pdf::loadView('pdfs.invoice', compact(
            'invoice',
            'company'
        ));

        $safeFileName = str_replace(
            ['/', '\\', ':', '*', '?', '"', '<', '>', '|'],
            '-',
            $invoice->code
        );

        return $pdf->stream(
            'Invoice-' . $safeFileName . '.pdf'
        );
    }

    public function download(Invoice $invoice)
    {
        $company = Auth::user()?->personel?->company;

        $invoice->load([
            'labJob.customer',
            'labJob.personel',
            'invoiceItems.source',
            'payments',
        ]);

        $pdf = Pdf::loadView('pdfs.invoice', compact(
            'invoice',
            'company'
        ));

        $safeFileName = str_replace(
            ['/', '\\', ':', '*', '?', '"', '<', '>', '|'],
            '-',
            $invoice->code
        );

        return $pdf->download(
            'Invoice-' . $safeFileName . '.pdf'
        );
    }
}
