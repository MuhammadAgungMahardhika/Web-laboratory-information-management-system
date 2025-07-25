<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Enums\QuotationStatusEnum;
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
                ->badgeColor(QuotationStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
