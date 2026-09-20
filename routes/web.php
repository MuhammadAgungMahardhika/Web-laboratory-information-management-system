<?php

use App\Http\Controllers\LabJobPdfController;
use App\Http\Controllers\QuotationPdfController;
use App\Http\Controllers\ReportPdfController;
use App\Http\Controllers\SamplePdfController;
use App\Http\Middleware\RedirectIfLoggedIn;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicePdfController;
use App\Http\Controllers\PaymentReceiptController;

Route::get('/', function ()
{
    return view('auth.login');
})->middleware(RedirectIfLoggedIn::class)->name('home');


// quotation
Route::get('/quotations/{quotation}/preview', [QuotationPdfController::class, 'preview'])->name('quotations.preview_pdf');
Route::get('/quotations/{quotation}/download', [QuotationPdfController::class, 'download'])->name('quotations.download_pdf');

// labjob 
Route::get('/lab_jobs/{labJob}/preview', [LabJobPdfController::class, 'previewTaskLetter'])->name('task_letters.preview');
Route::get('/lab_jobs/{labJob}/download', [LabJobPdfController::class, 'downloadTaskLetter'])->name('task_letters.download');
Route::get('/lab_jobs/{labJob}/lhp/preview', [LabJobPdfController::class, 'previewLhp'])->name('lhp.preview');
Route::get('/lab_jobs/{labJob}/lhp/download', [LabJobPdfController::class, 'downloadLhp'])->name('lhp.download');

// Invoice
Route::get(
    '/invoices/{invoice}/pdf/preview',
    [InvoicePdfController::class, 'preview']
)->name('invoices.preview_pdf');

Route::get(
    '/invoices/{invoice}/pdf/download',
    [InvoicePdfController::class, 'download']
)->name('invoices.download_pdf');
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

// payment receipt pdf
// payment receipt
Route::get('/payments/{payment}/receipt/preview', [PaymentReceiptController::class, 'previewReceipt'])
    ->name('payments.receipt.preview');
Route::get('/payments/{payment}/receipt/download', [PaymentReceiptController::class, 'downloadReceipt'])
    ->name('payments.receipt.download');
