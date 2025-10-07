<?php

use App\Http\Controllers\LabJobPdfController;
use App\Http\Controllers\QuotationPdfController;
use App\Http\Controllers\ReportPdfController;
use App\Http\Controllers\SamplePdfController;
use App\Http\Middleware\RedirectIfLoggedIn;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware(RedirectIfLoggedIn::class)->name('login');


// quotation
Route::get('/quotations/{quotation}/preview', [QuotationPdfController::class, 'preview'])->name('quotations.preview_pdf');
Route::get('/quotations/{quotation}/download', [QuotationPdfController::class, 'download'])->name('quotations.download_pdf');

// labjob 
Route::get('/lab_jobs/{labJob}/preview', [LabJobPdfController::class, 'previewTaskLetter'])->name('task_letters.preview');
Route::get('/lab_jobs/{labJob}/download', [LabJobPdfController::class, 'downloadTaskLetter'])->name('task_letters.download');

// sample label
Route::get('/sample/{sample}/download', [SamplePdfController::class, 'downloadLabel'])
    ->name('sample_labels.download');

// final report pdf
Route::get('/lab_jobs/{labJob}/final-report/preview', [ReportPdfController::class, 'previewFinalReport'])
    ->name('final_reports.preview');
Route::get('/lab_jobs/{labJob}/final-report/download', [ReportPdfController::class, 'downloadFinalReport'])
    ->name('final_reports.download');

// analyst report pdf
Route::get('/lab_jobs/{labJob}/analyst-report/preview', [LabJobPdfController::class, 'previewAnalystTestReport'])
    ->name('analyst_reports.preview');
Route::get('/lab_jobs/{labJob}/analyst-report/download', [LabJobPdfController::class, 'downloadAnalystTestReport'])
    ->name('analyst_reports.download');
