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
        $safeJobNumber = Str::of($labJob->job_number)->replace('/', '-');
        return $pdf->stream("Surat-Tugas-{$safeJobNumber}.pdf");
    }
    public function downloadTaskLetter(LabJob $labJob)
    {
        $company = Auth::user()?->personel?->company;
        $labJob->load(['quotation.customer', 'labJobPersonels.personel']);
        $pdf = Pdf::loadView('pdfs.task_letter', compact('labJob', 'company'));
        $safeJobNumber = Str::of($labJob->job_number)->replace('/', '-');
        return $pdf->download("Surat-Tugas-{$safeJobNumber}.pdf");
    }
}
