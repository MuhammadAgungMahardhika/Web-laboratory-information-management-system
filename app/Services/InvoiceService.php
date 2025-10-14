use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\LabJob;

class InvoiceService
{
    public function createInvoiceFromLabJob(LabJob $labJob): Invoice
    {
        // 1. Buat record Invoice
        $invoice = Invoice::create([
            'lab_job_id' => $labJob->id,
            // ... data invoice lainnya ...
        ]);

        // 2. Salin Item Tipe A (Sudah ada di LabJobItem)
        foreach ($labJob->labJobItems as $jobItem) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'source_type' => 'LabJobItem', // Tipe A
                'source_id' => $jobItem->id,
                'description' => $jobItem->description,
                'price' => $jobItem->price, // Ambil harga snapshot dari Job Item
                'quantity' => $jobItem->quantity,
            ]);
        }

        // 3. Salin Item Tipe B & C (Ambil dari Quotation)
        $otherItems = $labJob->quotation->quotationItems()
            ->whereIn('group', ['B', 'C'])
            ->get();

        foreach ($otherItems as $quotationItem) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'source_type' => 'QuotationItem', // Tipe B atau C
                'source_id' => $quotationItem->id,
                'description' => $quotationItem->description,
                'price' => $quotationItem->price, // Ambil harga snapshot dari Quotation Item
                'quantity' => $quotationItem->quantity,
            ]);
        }

        return $invoice;
    }
}
