<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use App\Models\LabJobItem;
use App\Models\QuotationItem;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoiceItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'invoiceItems';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                MorphToSelect::make('source')
                    ->label('Sumber Item')
                    ->searchable()
                    ->preload()
                    ->types([
                        // Tipe pertama: LabJobItem
                        Type::make(LabJobItem::class)
                            ->titleAttribute('description'), // Tampilkan deskripsi di dropdown
                        // Tipe kedua: QuotationItem
                        Type::make(QuotationItem::class)
                            ->titleAttribute('description'),
                    ])
                    ->live() // <-- Wajib untuk memicu update otomatis
                    ->columnSpanFull()->afterStateUpdated(function ($set, $state) {
                        $set('price', null);
                        $set('quantity', null);
                        $set('description', null);
                        // Jika sumber dipilih, ambil data harga dan kuantitas dari sumber tersebut
                        if ($state['source_type'] && $state['source_id']) {
                            $source = $state['source_type']::find($state['source_id']);
                            if ($source) {
                                if ($state['source_type'] == LabJobItem::class) {
                                    $price = $source->price;
                                    $quantity = $source->quantity;
                                    $set('price', $price);
                                    $set('quantity', $quantity);
                                } else if ($state['source_type'] == QuotationItem::class) {
                                    $price = $source->price;
                                    $quantity = $source->quantity;
                                    $set('price', $price);
                                    $set('quantity', $quantity);
                                }
                            }
                        }
                    }),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull()
                    // Nonaktifkan jika sumber sudah dipilih (data diambil otomatis)
                    ->disabled(fn(Get $get) => filled($get('source'))),

                TextInput::make('quantity')
                    ->label('Kuantitas')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->disabled(fn(Get $get) => filled($get('source'))),

                TextInput::make('price')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->required()
                    ->prefix('Rp')
                    ->disabled(fn(Get $get) => filled($get('source'))),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('Kuantitas')
                    ->numeric()
                    ->alignEnd(),

                TextColumn::make('price')
                    ->label('Harga Satuan')
                    ->money('IDR') // <-- Format sebagai mata uang
                    ->alignEnd()
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->alignEnd(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
