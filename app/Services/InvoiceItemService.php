<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceItemService
{
    public function recalculate(Invoice $invoice): Invoice
    {
        return app(InvoiceService::class)
            ->recalculateTotals($invoice);
    }
}
