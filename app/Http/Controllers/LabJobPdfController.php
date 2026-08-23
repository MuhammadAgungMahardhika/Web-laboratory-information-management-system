<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\LabJob;

class LabJobPdfController extends Controller
{
    public function previewTaskLetter(LabJob $labJob)
    {
        $company = Auth::user()?->personel?->company;
        $labJob->load(['quotation.customer', 'labJobPersonels.personel']);
        $pdf = Pdf::loadView('pdfs.task_letter', compact('labJob', 'company'));
        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');
        return $pdf->stream("Surat-Tugas-{$safeJobNumber}.pdf");
    }
    public function downloadTaskLetter(LabJob $labJob)
    {
        $company = Auth::user()?->personel?->company;
        $labJob->load(['quotation.customer', 'labJobPersonels.personel']);
        $pdf = Pdf::loadView('pdfs.task_letter', compact('labJob', 'company'));
        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');
        return $pdf->download("Surat-Tugas-{$safeJobNumber}.pdf");
    }

    /**
     * Menghasilkan pratinjau PDF laporan analis untuk sebuah LabJob.
     * @param LabJob $labJob
     * @return \Illuminate\Http\Response
     */
    public function previewAnalystTestReport(LabJob $labJob)
    {
        // Muat semua relasi yang diperlukan untuk laporan
        $labJob->load([
            'quotation.customer',
            'labJobItems.samples.testResults.parameter',
            'labJobItems.samples.testResults.testMethod',
            'labJobItems.samples.testResults.analystPersonel',
            'labJobItems.samples.testResults.validatorPersonel',
            // Tambahan relasi yang mungkin diperlukan:
            'labJobItems.samples' // untuk akses langsung ke samples
        ]);

        $company = Auth::user()?->personel?->company;

        $pdf = Pdf::loadView('pdfs.analyst_test_report', compact('labJob', 'company'))->setPaper('a4', 'portrait')
            ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);;

        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');
        return $pdf->stream("LPA-{$safeJobNumber}.pdf");
    }

    /**
     * Menghasilkan unduhan PDF laporan analis untuk sebuah LabJob.
     * @param LabJob $labJob
     * @return \Illuminate\Http\Response
     */
    public function downloadAnalystTestReport(LabJob $labJob)
    {
        // Muat semua relasi yang diperlukan untuk laporan
        $labJob->load([
            'quotation.customer',
            'labJobItems.samples.testResults.parameter',
            'labJobItems.samples.testResults.testMethod',
            'labJobItems.samples.testResults.analystPersonel',
            'labJobItems.samples.testResults.validatorPersonel',
            // Tambahan relasi yang mungkin diperlukan:
            'labJobItems.samples' // untuk akses langsung ke samples
        ]);

        $company = Auth::user()?->personel?->company;

        $pdf = Pdf::loadView('pdfs.analyst_test_report', compact('labJob', 'company'));

        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');
        return $pdf->download("LPA-{$safeJobNumber}.pdf");
    }
    public function previewLhp(LabJob $labJob)
    {
        $labJob->load([
            'quotation.customer',
            'labJobPersonels.personel',
            'labJobItems' => fn($q) => $q->where('group', 'A'),
            'labJobItems.samples.testResults.parameter.testMethod',
            // TODO: tambahkan relasi kategori parameter jika ada, mis:
            // 'labJobItems.samples.testResults.parameter.category',
        ]);

        $company = Auth::user()?->personel?->company;

        $pdf = Pdf::loadView('pdfs.lhp', compact('labJob', 'company'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');
        return $pdf->stream("LHP-{$safeJobNumber}.pdf");
    }

    public function downloadLhp(LabJob $labJob)
    {
        $labJob->load([
            'quotation.customer',
            'labJobPersonels.personel',
            'labJobItems' => fn($q) => $q->where('group', 'A'),
            'labJobItems.samples.testResults.parameter.testMethod',
        ]);

        $company = Auth::user()?->personel?->company;

        $pdf = Pdf::loadView('pdfs.lhp', compact('labJob', 'company'));

        $safeJobNumber = Str::of($labJob->code)->replace('/', '-');
        return $pdf->download("LHP-{$safeJobNumber}.pdf");
    }
}
