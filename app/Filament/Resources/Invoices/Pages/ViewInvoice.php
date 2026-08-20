<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\InvoiceResource\Actions\InvoiceStatusAction;
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

        $this->form->fill([
            'subtotal' => $this->record->subtotal,
            'discount_amount' => $this->record->discount_amount,
            'dpp_amount' => $this->record->dpp_amount,
            'ppn_amount' => $this->record->ppn_amount,
            'pph_amount' => $this->record->pph_amount,
            'total_amount' => $this->record->total_amount,
            'net_amount' => $this->record->net_amount,
        ]);
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
