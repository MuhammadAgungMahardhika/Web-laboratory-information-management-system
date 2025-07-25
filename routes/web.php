<?php

use App\Http\Controllers\QuotationPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
