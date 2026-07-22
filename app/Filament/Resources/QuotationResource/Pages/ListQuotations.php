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
        $counts = Quotation::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA')
                ->badge($counts->sum())
                ->badgeColor('gray'),
        ];

        foreach (QuotationStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->label())
                ->label(strtoupper($status->label()))
                ->badge($counts[$status->value] ?? 0)
                ->badgeColor(QuotationStatusEnum::color($status->value))
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('status', $status->value)
                );
        }

        return $tabs;
    }
}
