<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Impor facade PDF dari DomPDF
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Auth;

class QuotationPdfController extends Controller
{
    // ...
    private function loadQuotation(Quotation $quotation): Quotation
    {
        $quotation->load([
            'quotationItems' => function ($query) {
                $query->orderBy('group', 'asc');
            },
            'quotationItems.parameterQuotationItems',
            'customer',
            'personel',
            'personel.position',
        ]);

        return $quotation;
    }

    private function buildPdf(Quotation $quotation): \Barryvdh\Snappy\PdfWrapper
    {
        $company = Auth::user()?->personel?->company;
        $this->loadQuotation($quotation);

        // Render partial views untuk header dan footer
        $headerHtml = view('pdfs.quotation-header', compact('quotation', 'company'))->render();
        $footerHtml = view('pdfs.quotation-footer', compact('company'))->render();

        // Tulis ke file temp karena wkhtmltopdf butuh path file, bukan string HTML
        $headerPath = tempnam(sys_get_temp_dir(), 'quo_header_') . '.html';
        $footerPath = tempnam(sys_get_temp_dir(), 'quo_footer_') . '.html';
        file_put_contents($headerPath, $headerHtml);
        file_put_contents($footerPath, $footerHtml);

        $pdf = SnappyPdf::loadView('pdfs.quotation', compact('quotation', 'company'))
            ->setOption('margin-top',    '60mm')  // sesuaikan tinggi header Anda
            ->setOption('margin-bottom', '18mm')  // sesuaikan tinggi footer
            ->setOption('margin-left',   '15mm')
            ->setOption('margin-right',  '15mm')
            ->setOption('header-html',   $headerPath)
            ->setOption('footer-html',   $footerPath)
            ->setOption('enable-local-file-access', true)
            ->setOption('encoding', 'UTF-8')
            ->setOption('disable-smart-shrinking', true)
            ->setOption('print-media-type', true);

        // Cleanup temp files setelah PDF dibuat
        register_shutdown_function(function () use ($headerPath, $footerPath) {
            @unlink($headerPath);
            @unlink($footerPath);
        });

        return $pdf;
    }

    public function preview(Quotation $quotation)
    {
        $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $quotation->quotation_number);

        return $this->buildPdf($quotation)
            ->inline('Penawaran-' . $safeFileName . '.pdf');
    }

    public function download(Quotation $quotation)
    {
        $safeFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $quotation->quotation_number);

        return $this->buildPdf($quotation)
            ->download('Penawaran-' . $safeFileName . '.pdf');
    }
}
