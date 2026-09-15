<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Company; // Asumsi model Company sudah ada
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PaymentReceiptController extends Controller
{
    public function previewReceipt(Payment $payment)
    {
        $payment->load([
            'invoice.labJob.customer',
        ]);

        $company = Company::where('is_main_company', true)->first();
        $invoice = $payment->invoice;

        $pdf = Pdf::loadView('pdfs.payment_receipt', compact('payment', 'company', 'invoice'))
            ->setPaper('a5');

        $safeReceiptNumber = Str::of($payment->receipt_number)->replace('/', '-');

        return $pdf->stream("Kuitansi-{$safeReceiptNumber}.pdf");
    }

    public function downloadReceipt(Payment $payment)
    {
        $payment->load([
            'invoice.labJob.customer',
        ]);

        $company = Company::where('is_main_company', true)->first();
        $invoice = $payment->invoice;

        $pdf = Pdf::loadView('pdfs.payment_receipt', compact('payment', 'company', 'invoice'))
            ->setPaper('a5');

        $safeReceiptNumber = Str::of($payment->receipt_number)->replace('/', '-');

        return $pdf->download("Kuitansi-{$safeReceiptNumber}.pdf");
    }
}
