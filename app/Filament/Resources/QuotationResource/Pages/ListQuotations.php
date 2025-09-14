<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\QuotationResource;
use App\Models\Enums\QuotationStatusEnum;
use App\Models\Quotation;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListQuotations extends ListRecords
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        // Tab "SEMUA"
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA')
                ->badge(Quotation::count()),
        ];

        // Hitung jumlah per status dalam 1 query
        $counts = Quotation::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Buat tab untuk tiap status
        foreach (QuotationStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->value)
                ->badge($counts[$status->value] ?? 0) // pakai hasil pluck
                ->badgeColor(QuotationStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
