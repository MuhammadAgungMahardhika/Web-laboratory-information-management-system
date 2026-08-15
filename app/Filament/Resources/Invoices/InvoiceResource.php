<?php

namespace App\Filament\Resources\Invoices;

use App\Filament\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Resources\Invoices\Pages\EditInvoice;
use App\Filament\Resources\Invoices\Pages\ListInvoices;
use App\Filament\Resources\Invoices\Pages\ViewInvoice;
use App\Filament\Resources\Invoices\RelationManagers\InvoiceItemsRelationManager;
use App\Filament\Resources\Invoices\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\Invoices\Schemas\InvoiceForm;
use App\Filament\Resources\Invoices\Schemas\InvoiceInfolist;
use App\Filament\Resources\Invoices\Tables\InvoicesTable;
use App\Models\Enums\InvoiceStatusEnum;
use App\Models\Invoice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationLabel = 'Tagihan';
    protected static ?string $label = 'Tagihan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCurrencyDollar;
    protected static ?int $navigationSort = 3;
    protected static ?int $draftCount = null;

    protected static function draftCount(): int
    {
        return static::$draftCount ??=
            static::getEloquentQuery()
            ->where('status', InvoiceStatusEnum::Draft->value)
            ->count();
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::draftCount();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::draftCount() > 0
            ? 'gray'
            : 'success';
    }
    public static function form(Schema $schema): Schema
    {
        return InvoiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InvoiceItemsRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'view' => ViewInvoice::route('/{record}'),
            'edit' => EditInvoice::route('/{record}/edit'),
        ];
    }
}
