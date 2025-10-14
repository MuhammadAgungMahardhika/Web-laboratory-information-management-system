<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Enums\InvoiceStatusEnum;
use App\Models\Invoice;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
        ];
    }

    public function getTabs(): array
    {
        // Tab "SEMUA"
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA'),
        ];

        // Hitung jumlah per status sekali query
        $counts = Invoice::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Buat tab untuk tiap status
        foreach (InvoiceStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->value)
                ->badge($counts[$status->value] ?? 0)
                ->badgeColor(InvoiceStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
