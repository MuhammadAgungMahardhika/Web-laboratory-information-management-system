<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Str;

class SamplePdfController extends Controller
{
    //

    public function downloadLabel(Sample $sample)
    {
        // Ambil semua sampel yang dipilih
        $pdf = Pdf::loadView('pdfs.sample_label', compact('sample'));
        // --- PERBAIKAN DI SINI: Atur ukuran kertas di controller ---
        // ukuran label 50mm x 30mm (203 dpi ≈ 8 dots/mm → 5cm=141.7pt, 3cm=85pt)
        $labelWidth  = 141.7; // 5cm
        $labelHeight = 85;    // 3cm
        $pdf->setPaper([0, 0, $labelWidth, $labelHeight]);
        $safeFileName = 'label-' . Str::uuid();
        return $pdf->download("{$safeFileName}.pdf");
    }

    public function previewAnalystTestReport(Sample $sample)
    {
        // Muat semua relasi yang diperlukan, dimulai dari objek Sample
        $sample->load([
            'labJobItem.labJob.quotation.customer',
            'testResults.parameter',
            'testResults.testMethod',
            'testResults.analystPersonel',
            'testResults.validatorPersonel'
        ]);

        $company = Auth::user()?->personel?->company;

        $pdf = Pdf::loadView('pdfs.analyst_test_report', compact('sample', 'company'));

        $safeSampleCode = Str::of($sample->code)->replace('/', '-');
        return $pdf->stream("LPA-{$safeSampleCode}.pdf");
    }

    public function downloadAnalystTestReport(Sample $sample)
    {
        $sample->load([
            'labJobItem.labJob.quotation.customer',
            'testResults.parameter',
            'testResults.testMethod',
            'testResults.analystPersonel',
            'testResults.validatorPersonel'
        ]);

        $company = Auth::user()?->personel?->company;

        $pdf = Pdf::loadView('pdfs.analyst_test_report', compact('sample', 'company'));

        $safeSampleCode = Str::of($sample->code)->replace('/', '-');
        return $pdf->download("LPA-{$safeSampleCode}.pdf");
    }
}
