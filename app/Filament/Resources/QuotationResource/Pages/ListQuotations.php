<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Enums\QuotationStatusEnum;
use App\Models\Quotation;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListQuotations extends ListRecords
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA'),
        ];
        foreach (QuotationStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->value)
                ->badge(Quotation::query()->where('status', $status->value)->count()) // Add count for each status tab
                ->badgeColor(QuotationStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
