<?php

namespace App\Observers;

use App\Models\InvoiceItem;
use App\Services\InvoiceCalculationService;
use App\Services\InvoiceItemService;

class InvoiceItemObserver
{
    public function created(InvoiceItem $invoiceItem): void
    {
        $this->recalculate($invoiceItem);
    }

    public function updated(InvoiceItem $invoiceItem): void
    {
        $this->recalculate($invoiceItem);
    }

    public function deleted(InvoiceItem $invoiceItem): void
    {
        $this->recalculate($invoiceItem);
    }

    protected function recalculate(
        InvoiceItem $invoiceItem
    ): void {
        if (! $invoiceItem->invoice_id) {
            return;
        }

        $invoiceItem->loadMissing('invoice');

        if ($invoiceItem->invoice) {
            app(InvoiceItemService::class)
                ->recalculate($invoiceItem->invoice);
        }
    }
}
