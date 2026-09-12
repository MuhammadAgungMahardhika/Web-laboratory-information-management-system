<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\Actions\InvoiceStatusAction;
use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Livewire\Attributes\On;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;
    #[On('invoice-updated')]
    public function refreshInvoice(): void
    {
        $this->record->refresh();
        $this->data['subtotal'] = $this->record->subtotal;

        $this->data['discount_percentage'] =
            $this->record->discount_percentage;

        $this->data['discount_amount'] =
            $this->record->discount_amount;

        $this->data['dpp_amount'] =
            $this->record->dpp_amount;

        $this->data['ppn_percentage'] =
            $this->record->ppn_percentage;

        $this->data['ppn_amount'] =
            $this->record->ppn_amount;

        $this->data['pph_percentage'] =
            $this->record->pph_percentage;

        $this->data['pph_amount'] =
            $this->record->pph_amount;

        $this->data['total_amount'] =
            $this->record->total_amount;

        $this->data['net_amount'] =
            $this->record->net_amount;
        $this->data['status'] =
            $this->record->status;
    }
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            InvoiceStatusAction::preview(),
            InvoiceStatusAction::download(),
        ];
    }
}
