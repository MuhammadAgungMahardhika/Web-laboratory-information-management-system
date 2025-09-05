<?php

namespace App\Http\Controllers;

use App\Models\LabJob;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Company; // Asumsi model Company sudah ada

class ReportPdfController extends Controller
{
    public function preview(LabJob $labJob)
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

        $safeJobNumber = Str::of($labJob->job_number)->replace('/', '-');

        return $pdf->stream("LHP-{$safeJobNumber}.pdf");
    }
    public function download(LabJob $labJob)
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

        $safeJobNumber = Str::of($labJob->job_number)->replace('/', '-');

        return $pdf->download("LHP-{$safeJobNumber}.pdf");
    }
}
