<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\Actions\InvoiceStatusAction;
use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;

class EditInvoice extends EditRecord
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
            'status' => $this->record->status,
        ]);
    }
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            InvoiceStatusAction::preview(),
            InvoiceStatusAction::download(),
        ];
    }
}
