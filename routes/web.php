<?php

use App\Http\Controllers\LabJobPdfController;
use App\Http\Controllers\QuotationPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/quotations/{quotation}/preview', [QuotationPdfController::class, 'preview'])->name('quotations.preview_pdf');
Route::get('/quotations/{quotation}/download', [QuotationPdfController::class, 'download'])->name('quotations.download_pdf');
Route::get('/lab_jobs/{labJob}/preview', [LabJobPdfController::class, 'previewTaskLetter'])->name('lab_jobs.preview_task_letter');
Route::get('/lab_jobs/{labJob}/download', [LabJobPdfController::class, 'downloadTaskLetter'])->name('lab_jobs.download_task_letter');
