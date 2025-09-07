<?php

use App\Http\Controllers\LabJobPdfController;
use App\Http\Controllers\QuotationPdfController;
use App\Http\Controllers\ReportPdfController;
use App\Http\Controllers\SamplePdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


// quotation
Route::get('/quotations/{quotation}/preview', [QuotationPdfController::class, 'preview'])->name('quotations.preview_pdf');
Route::get('/quotations/{quotation}/download', [QuotationPdfController::class, 'download'])->name('quotations.download_pdf');

// labjob 
Route::get('/lab_jobs/{labJob}/preview', [LabJobPdfController::class, 'previewTaskLetter'])->name('lab_jobs.preview_task_letter');
Route::get('/lab_jobs/{labJob}/download', [LabJobPdfController::class, 'downloadTaskLetter'])->name('lab_jobs.download_task_letter');

// sample label
Route::get('/sample/{sample}/download', [SamplePdfController::class, 'downloadLabel'])
    ->name('samples.download_label');

// report pdf
Route::get('/lab_jobs/{labJob}/report/preview', [ReportPdfController::class, 'preview'])
    ->name('reports.preview_report');
Route::get('/lab_jobs/{labJob}/report/download', [ReportPdfController::class, 'download'])
    ->name('reports.download_report');
