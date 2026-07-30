<?php

namespace App\Http\Controllers;

use App\Models\LabJob;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Company; // Asumsi model Company sudah ada

class ReportPdfController extends Controller
{
    public function previewFinalReport(LabJob $labJob)
    {
        // Muat semua relasi yang diperlukan untuk laporan
        $labJob->load([
            'quotation.customer',
            'labJobItems.samples.testResults.parameter',
            'labJobItems.samples.testResults.analystPersonel',
            'labJobItems.samples.testResults.validatorPersonel'
        ]);

        $company = Company::where('is_main_company', true)->first();

        $pdf = Pdf::loadView('pdfs.test_report', compact('labJob', 'company'));

        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');

        return $pdf->stream("LHP-{$safeJobNumber}.pdf");
    }
    public function downloadFinalReport(LabJob $labJob)
    {
        // Muat semua relasi yang diperlukan untuk laporan
        $labJob->load([
            'quotation.customer',
            'labJobItems.samples.testResults.parameter',
            'labJobItems.samples.testResults.analystPersonel',
            'labJobItems.samples.testResults.validatorPersonel'
        ]);

        $company = Company::where('is_main_company', true)->first();

        $pdf = Pdf::loadView('pdfs.test_report', compact('labJob', 'company'));

        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');

        return $pdf->download("LHP-{$safeJobNumber}.pdf");
    }

    public function printReport(LabJob $labJob)
    {
        // Muat semua relasi yang diperlukan untuk laporan
        $labJob->load([
            'quotation.customer',
            'labJobItems.samples.testResults.parameter',
            'labJobItems.samples.testResults.analystPersonnel',
            'labJobItems.samples.testResults.validatorPersonnel'
        ]);

        $company = Company::where('is_main_company', true)->first();

        $pdf = Pdf::loadView('pdfs.test_report', compact('labJob', 'company'));

        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');

        return $pdf->download("LHP-{$safeJobNumber}.pdf");
    }
}
