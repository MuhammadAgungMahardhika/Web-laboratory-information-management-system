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
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class InvoiceItemsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'invoiceItems';
    protected static ?string $label = 'Rincian Tagihan';
    protected static ?string $title = "Rincian Tagihan";
    public function form(Schema $schema): Schema
    {
        $ownerRecord =  $this->ownerRecord;
        return $schema
            ->components([
                Toggle::make('manual_input_mode')
                    ->label('Input Manual (Non-Source Item)')
                    ->live()
                    ->dehydrated(false)
                    ->default(fn(Get $get) => filled($get('source_id')) ? true : false),
                MorphToSelect::make('source')
                    ->label('Sumber Item')
                    ->searchable()
                    ->preload()
                    ->required(fn(Get $get) => !$get('manual_input_mode'))
                    ->visible(fn(Get $get) => !$get('manual_input_mode'))
                    ->types([
                        Type::make(LabJobItem::class)
                            ->label('Lab Job')
                            ->titleAttribute('description')
                            // Logika filter LabJobItem...
                            ->modifyOptionsQueryUsing(function (Builder $query, $record) use ($ownerRecord) {
                                // Di Relation Manager, kita harus mengakses ID LabJob dari Invoice induk (ownerRecord)
                                $invoiceItemId = $record->id ?? null;
                                $labJobId = $ownerRecord->lab_job_id ?? null;
                                // Jika Lab Job ditemukan, filter LabJobItem berdasarkan ID tersebut
                                if ($labJobId) {
                                    return $query->where('lab_job_id', $labJobId)
                                        ->whereDoesntHave('invoiceItems', fn($q) => $q->where('id', '!=',  $invoiceItemId));
                                }
                                return $query->whereRaw('1 = 0'); // Tampilkan hasil kosong jika Lab Job tidak diketahui
                            }),

                        // --- Tipe 2: QuotationItem (Tipe B & C) ---
                        Type::make(QuotationItem::class)
                            ->label('Penawaran')
                            ->titleAttribute('description')
                            ->modifyOptionsQueryUsing(function (Builder $query, $record) use ($ownerRecord) {
                                // Mendapatkan ID Quotation dari Invoice induk
                                $invoiceItemId = $record->id ?? null;
                                $quotationId = $ownerRecord->labJob->quotation_id ?? null;

                                // Hanya tampilkan item Tipe B/C yang belum pernah di-invoice
                                return $query
                                    ->where('quotation_id', $quotationId) // Hanya dari Quotation ini
                                    ->whereIn('group', ['B', 'C']) // Hanya Tipe B dan C
                                    // Mencegah duplikasi: Item yang sudah di-snapshot di tabel InvoiceItem manapun
                                    ->whereDoesntHave('invoiceItems', fn($q) => $q->where('id', '!=',  $invoiceItemId));
                            }),
                    ])
                    ->live() // <-- Wajib untuk memicu update otomatis
                    ->columnSpanFull()
                    ->afterStateUpdated(function ($set, $state) {
                        // Jika sumber dipilih, ambil data harga dan kuantitas dari sumber tersebut
                        if ($state['source_type'] && $state['source_id']) {
                            $set('price', null);
                            $set('quantity', null);
                            $set('description', null);
                            $source = $state['source_type']::find($state['source_id']);
                            if ($source) {
                                if ($state['source_type'] == LabJobItem::class) {
                                    $description = $source->description;
                                    $price = $source->price;
                                    $quantity = $source->quantity;

                                    $set('description', $description);
                                    $set('price', $price);
                                    $set('quantity', $quantity);
                                } else if ($state['source_type'] == QuotationItem::class) {
                                    $description = $source->description;
                                    $price = $source->price;
                                    $quantity = $source->quantity;

                                    $set('description', $description);
                                    $set('price', $price);
                                    $set('quantity', $quantity);
                                }
                            }
                        }
                    }),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()

                    ->readOnly(fn(Get $get) =>  !$get('manual_input_mode'))
                    ->columnSpanFull(),

                TextInput::make('quantity')
                    ->label('Kuantitas')
                    ->numeric()
                    ->required()

                    ->readOnly(fn(Get $get) =>  !$get('manual_input_mode'))
                    ->minValue(1),

                TextInput::make('price')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->required()
                    ->readOnly(fn(Get $get) =>  !$get('manual_input_mode'))
                    ->prefix('Rp'),
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
                    ->alignEnd()
                    ->summarize(
                        Summarizer::make()
                            ->label('Total:')
                            // --- PERBAIKAN DI SINI: Gunakan closure kustom untuk menjumlahkan ---
                            ->using(
                                fn(QueryBuilder $query): string =>
                                // Hitung total dari kuantitas * harga satuan untuk semua item yang difilter
                                $query->sum(DB::raw('quantity * price'))
                            )
                            ->money('IDR')
                    ),
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
