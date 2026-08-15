<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use App\Models\Enums\PaymentStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;

    protected static string $relationship = 'payments';

    protected static ?string $label = 'Pembayaran';

    protected static ?string $title = 'Riwayat Pembayaran';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Kode Pembayaran')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(fn() => 'PAY-' . now()->format('YmdHis'))
                    ->maxLength(50)
                    ->readOnly(),

                DatePicker::make('payment_date')
                    ->label('Tanggal Pembayaran')
                    ->required()
                    ->default(now())
                    ->native(false),

                TextInput::make('amount_paid')
                    ->label('Jumlah Dibayar')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0)
                    ->inputMode('decimal'),

                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->required()
                    ->options([
                        'cash' => 'Tunai',
                        'transfer' => 'Transfer Bank',
                        'debit' => 'Kartu Debit',
                        'credit_card' => 'Kartu Kredit',
                        'qris' => 'QRIS',
                        'other' => 'Lainnya',
                    ])
                    ->native(false),

                TextInput::make('reference_number')
                    ->label('Nomor Referensi')
                    ->placeholder('Contoh: Nomor transaksi / nomor bukti transfer')
                    ->maxLength(255),

                Select::make('status')
                    ->label('Status Pembayaran')
                    ->required()
                    ->options(
                        collect(PaymentStatusEnum::cases())
                            ->mapWithKeys(fn(PaymentStatusEnum $status) => [
                                $status->value => $status->label(),
                            ])
                            ->toArray()
                    )
                    ->default(PaymentStatusEnum::default()->value)
                    ->native(false),

                FileUpload::make('attachment_path')
                    ->label('Bukti Pembayaran')
                    ->disk('public')
                    ->directory('payments')
                    ->visibility('private')
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'application/pdf',
                    ])
                    ->maxSize(5120)
                    ->downloadable()
                    ->openable(),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->placeholder('Tambahkan catatan pembayaran jika diperlukan...')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('payment_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('amount_paid')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(
                        fn(?string $state): string => match ($state) {
                            'cash' => 'Tunai',
                            'transfer' => 'Transfer Bank',
                            'debit' => 'Kartu Debit',
                            'credit_card' => 'Kartu Kredit',
                            'qris' => 'QRIS',
                            'other' => 'Lainnya',
                            default => '-',
                        }
                    )
                    ->badge(),

                TextColumn::make('reference_number')
                    ->label('Nomor Referensi')
                    ->placeholder('-')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn(int $state): string =>
                        PaymentStatusEnum::from($state)->label()
                    )
                    ->color(
                        fn(int $state): string =>
                        PaymentStatusEnum::color($state)
                    ),

                TextColumn::make('created_at')
                    ->label('Dicatat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pembayaran')
                    ->icon(Heroicon::OutlinedPlus),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Ubah'),

                DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ]);
    }
}
