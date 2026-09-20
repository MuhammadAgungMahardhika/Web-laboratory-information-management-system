<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use App\Models\InvoiceItem;
use App\Models\LabJobItem;
use App\Models\QuotationItem;
use App\Services\InvoiceService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
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
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class InvoiceItemsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'invoiceItems';
    protected static ?string $label = 'Rincian Tagihan';
    protected static ?string $title = 'Rincian Tagihan';

    /**
     * ==========================================
     * FORM
     * ==========================================
     */
    public function form(Schema $schema): Schema
    {
        $ownerRecord = $this->ownerRecord;

        return $schema
            ->components([
                Toggle::make('manual_input_mode')
                    ->label('Input Manual')
                    ->helperText(
                        'Aktifkan jika item tidak berasal dari Lab Job atau Penawaran.'
                    )
                    ->live(onBlur: true)
                    ->dehydrated(false)
                    ->default(
                        fn(Get $get): bool =>
                        filled($get('source_id'))
                    )
                    ->columnSpanFull(),

                /*
                 * ==========================================
                 * SUMBER ITEM
                 * ==========================================
                 */
                MorphToSelect::make('source')
                    ->label('Sumber Item')
                    ->searchable()
                    ->preload()
                    ->required(
                        fn(Get $get): bool =>
                        ! $get('manual_input_mode')
                    )
                    ->visible(
                        fn(Get $get): bool =>
                        ! $get('manual_input_mode')
                    )
                    ->types([
                        Type::make(LabJobItem::class)
                            ->label('Lab Job')
                            ->titleAttribute('description')
                            ->modifyOptionsQueryUsing(
                                function (
                                    Builder $query,
                                    $record
                                ) use (
                                    $ownerRecord
                                )
                                {
                                    $invoiceItemId =
                                        $record?->id;

                                    $labJobId =
                                        $ownerRecord?->lab_job_id;

                                    if (! $labJobId)
                                    {
                                        return $query
                                            ->whereRaw(
                                                '1 = 0'
                                            );
                                    }

                                    return $query
                                        ->where('lab_job_id',  $labJobId)
                                        ->whereDoesntHave(
                                            'invoiceItems',
                                            function ($q) use ($invoiceItemId)
                                            {
                                                if ($invoiceItemId)
                                                {
                                                    $q->where(
                                                        'id',
                                                        '!=',
                                                        $invoiceItemId
                                                    );
                                                }
                                            }
                                        );
                                }
                            ),

                        /*
                         * ==================================
                         * QUOTATION ITEM
                         * ==================================
                         */
                        Type::make(QuotationItem::class)
                            ->label('Penawaran')
                            ->titleAttribute('description')
                            ->modifyOptionsQueryUsing(
                                function (Builder $query,  $record) use ($ownerRecord)
                                {
                                    $invoiceItemId = $record?->id;
                                    $quotationId =
                                        $ownerRecord
                                        ?->labJob
                                        ?->quotation_id;

                                    if (! $quotationId)
                                    {
                                        return $query
                                            ->whereRaw(
                                                '1 = 0'
                                            );
                                    }

                                    return $query
                                        ->where('quotation_id', $quotationId)
                                        ->whereIn('group', ['B', 'C'])
                                        ->whereDoesntHave(
                                            'invoiceItems',
                                            function ($q) use ($invoiceItemId)
                                            {
                                                if ($invoiceItemId)
                                                {
                                                    $q->where(
                                                        'id',
                                                        '!=',
                                                        $invoiceItemId
                                                    );
                                                }
                                            }
                                        );
                                }
                            ),
                    ])
                    ->live(onBlur: true)
                    ->columnSpanFull()
                    ->afterStateUpdated(
                        function (Set $set, ?array $state): void
                        {
                            if (! $state || empty($state['source_type']) || empty($state['source_id']))
                            {
                                return;
                            }


                            $sourceType = $state['source_type'];
                            $sourceId =  $state['source_id'];
                            $source = $sourceType::find($sourceId);
                            if (! $source)
                            {
                                return;
                            }

                            /*
                             * Snapshot source ke InvoiceItem.
                             */
                            $quantity = (float) ($source->quantity ?? 1);
                            $price = (float) ($source->price ?? 0);

                            $set('description',  $source->description);

                            $set(
                                'quantity',
                                $quantity
                            );

                            $set(
                                'price',
                                $price
                            );

                            self::setItemSubtotal(
                                $set,
                                $quantity,
                                $price
                            );
                        }
                    ),

                /*
                 * ==========================================
                 * DESKRIPSI
                 * ==========================================
                 */
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->disabled(
                        fn(Get $get): bool =>
                        ! $get('manual_input_mode')
                    )
                    ->dehydrated()
                    ->rows(3)
                    ->columnSpanFull(),

                /*
                 * ==========================================
                 * QUANTITY
                 * ==========================================
                 */
                TextInput::make('quantity')
                    ->label('Kuantitas')
                    ->numeric()
                    ->required()
                    ->minValue(0.01)
                    ->disabled(
                        fn(Get $get): bool =>
                        ! $get('manual_input_mode')
                    )
                    ->dehydrated()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        function (
                            Get $get,
                            Set $set
                        ): void
                        {
                            self::setItemSubtotal(
                                $set,
                                (float) (
                                    $get('quantity') ?? 0
                                ),
                                (float) (
                                    $get('price') ?? 0
                                )
                            );
                        }
                    ),

                /*
                 * ==========================================
                 * HARGA
                 * ==========================================
                 */
                TextInput::make('price')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->disabled(
                        fn(Get $get): bool =>
                        ! $get('manual_input_mode')
                    )
                    ->dehydrated()
                    ->prefix('Rp')
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        function (
                            Get $get,
                            Set $set
                        ): void
                        {
                            self::setItemSubtotal(
                                $set,
                                (float) (
                                    $get('quantity') ?? 0
                                ),
                                (float) (
                                    $get('price') ?? 0
                                )
                            );
                        }
                    ),

                /*
                 * ==========================================
                 * SUBTOTAL ITEM
                 * ==========================================
                 */
                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated()
                    ->default(0)
                    ->columnSpanFull(),
            ]);
    }

    /**
     * Hitung subtotal InvoiceItem.
     */
    protected static function setItemSubtotal(
        Set $set,
        float $quantity,
        float $price
    ): void
    {
        $subtotal =
            $quantity * $price;

        $set(
            'subtotal',
            round(
                $subtotal,
                2
            )
        );
    }

    /**
     * ==========================================
     * TABLE
     * ==========================================
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute(
                'description'
            )
            ->columns([

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric(
                        decimalPlaces: 2
                    )
                    ->alignEnd(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->alignEnd()
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->alignEnd()
                    ->sortable()
                    ->summarize(
                        Summarizer::make()
                            ->label('Total')
                            ->using(
                                fn(
                                    QueryBuilder $query
                                ): float =>
                                (float) $query->sum(
                                    DB::raw(
                                        'quantity * price'
                                    )
                                )
                            )
                            ->money('IDR')
                    ),
            ])

            /*
             * ==========================================
             * CREATE
             * ==========================================
             */
            ->headerActions([
                CreateAction::make()
                    ->after(
                        function (): void
                        {
                            app(InvoiceService::class)
                                ->recalculateTotals(
                                    $this->ownerRecord
                                );

                            $this->dispatch(
                                'invoice-updated'
                            );
                        }
                    ),
            ])

            /*
             * ==========================================
             * EDIT / DELETE
             * ==========================================
             */
            ->recordActions([

                EditAction::make()
                    ->after(
                        function (): void
                        {
                            app(InvoiceService::class)
                                ->recalculateTotals(
                                    $this->ownerRecord
                                );

                            $this->dispatch(
                                'invoice-updated'
                            );
                        }
                    ),

                DeleteAction::make()
                    ->requiresConfirmation()
                    ->after(
                        function (): void
                        {
                            app(InvoiceService::class)
                                ->recalculateTotals(
                                    $this->ownerRecord
                                );

                            $this->dispatch(
                                'invoice-updated'
                            );
                        }
                    ),
            ])

            /*
             * ==========================================
             * BULK DELETE
             * ==========================================
             */
            ->toolbarActions([
                BulkActionGroup::make([

                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->after(
                            function (): void
                            {
                                app(InvoiceService::class)
                                    ->recalculateTotals(
                                        $this->ownerRecord
                                    );

                                $this->dispatch(
                                    'invoice-updated'
                                );
                            }
                        ),
                ]),
            ]);
    }
}
