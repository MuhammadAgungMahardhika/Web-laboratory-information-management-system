<?php

namespace App\Filament\Resources\QuotationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\TestPackage;
use App\Models\Regulation;
use App\Models\QuotationItem; // Import model QuotationItem
use App\Models\QuotationItemParameter; // Import model QuotationItemParameter
use App\Models\Parameter; // Import model Parameter
use App\Services\QuotationItemService;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class QuotationItemRelationManager extends RelationManager
{
    protected static string $relationship = 'quotationItems';
    protected static ?string $label = 'Detail penawaran';
    protected static ?string $title = "Detail penawaran";
    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Select::make('test_package_id')
                    ->label('Paket Pengujian')
                    ->relationship('testPackage', 'name')
                    ->preload()
                    ->searchable()
                    ->helperText('Pilih paket pengujian jika item adalah sampel')
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('description', null);
                        $set('price', null);
                        $set('regulation_id', null);
                        $set('regulation_name', null);

                        if ($state) {
                            $testPackage = TestPackage::find($state);
                            if ($testPackage) {
                                $set('description', $testPackage->name);
                                $set('price', $testPackage->price);
                                if ($testPackage->regulation) {
                                    $set('regulation_id', $testPackage->regulation->id);
                                    $set('regulation_name', $testPackage->regulation->name);
                                }
                            }
                        }
                    }),
                Section::make([
                    Forms\Components\TextInput::make('description')
                        ->label('Keterangan')
                        ->autocomplete(false)
                        ->datalist([
                            'Engineer dan Mobilisasi'
                        ])
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Deskripsi akan otomatis terisi dari Paket Pengujian'),
                    Forms\Components\TextInput::make('regulation_name')
                        ->label('Nama Regulasi')
                        ->autocomplete(false)
                        ->maxLength(255),

                    Forms\Components\Hidden::make('regulation_id'),
                    Forms\Components\TextInput::make('quantity')
                        ->label('Jumlah')
                        ->numeric()
                        ->required()
                        ->default(1),
                    Forms\Components\TextInput::make('unit')
                        ->label('Satuan')
                        ->datalist([
                            'Sampel',
                            'Ls'
                        ])
                        ->required()
                        ->autocomplete(false)
                        ->maxLength(50),
                    Forms\Components\TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->required()
                        ->default(0.00)
                        ->step(0.01),
                    Forms\Components\TextInput::make('location')
                        ->label('Lokasi Pengambilan Sampel')
                        ->maxLength(100)
                        ->nullable(),
                ])->columns(2),
                Select::make('parameters')->searchable()->multiple()->relationship('parameters', 'name')->preload(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->size(TextColumnSize::Small)
                    ->searchable(),
                Tables\Columns\TextColumn::make('regulation_name')
                    ->label('Regulasi')
                    ->size(TextColumnSize::Small)
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->size(TextColumnSize::Small)
                    ->label('Lokasi pengambilan sampel'),
                Tables\Columns\TextColumn::make('quantity')
                    ->size(TextColumnSize::Small)
                    ->label('Kuantitas'),
                Tables\Columns\TextColumn::make('unit')
                    ->size(TextColumnSize::Small)
                    ->label('Satuan'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->alignEnd()
                    ->size(TextColumnSize::Small)
                    ->money('IDR')
                    ->sortable(),
                // Tambahkan kolom total_price
                // Kolom total_price
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Harga Total')
                    ->alignEnd()
                    ->size(TextColumnSize::Small)
                    ->money('IDR')
                    ->getStateUsing(fn(QuotationItem $record): float => $record->quantity * $record->price)
                    ->summarize(
                        Summarizer::make('total_price')
                            ->label('Total Penawaran')
                            ->using(function (\Illuminate\Database\Eloquent\Collection $records): string {
                                $total = 0;
                                foreach ($records as $record) {
                                    // Akses langsung properti dari model, memastikan dapat nilai yang sudah di-hydrate
                                    $total += ($record->quantity * $record->price);
                                }

                                return Number::currency($total, 'IDR');
                            })
                    ),

                Tables\Columns\TextColumn::make('quotationItemParameters.parameter_name')
                    ->badge()
                    ->size(TextColumnSize::Small)
                    ->label('Parameter'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function (QuotationItem $record, array $data) {
                        // Inisialisasi service
                        $quotationItemService = new QuotationItemService();
                        $quotationItemService->syncQuotationItemParameters($record);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (QuotationItem $record, array $data) {
                        // Inisialisasi service
                        $quotationItemService = new QuotationItemService();
                        $quotationItemService->syncQuotationItemParameters($record);
                    }),
                Tables\Actions\DeleteAction::make()
                    ->using(function (Tables\Actions\DeleteAction $action, QuotationItem $record) {
                        return DB::transaction(function () use ($action, $record) {
                            try {
                                // Hapus QuotationItemParameter terkait terlebih dahulu
                                $record->quotationItemParameters()->delete(); // Menggunakan relasi hasMany

                                // Kemudian hapus QuotationItem itu sendiri
                                // Jika onDelete('cascade') di FK quotation_items, ini akan otomatis
                                // Jika tidak, Anda perlu memastikan ini dihapus juga.
                                $record->delete();
                                return true; // Beri tahu Filament bahwa penghapusan berhasil
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->danger()
                                    ->title('Gagal menghapus item penawaran')
                                    ->body('Terjadi kesalahan: ' . $e->getMessage())
                                    ->send();
                                return false; // Beri tahu Filament bahwa penghapusan gagal
                            }
                        });
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->using(function (Tables\Actions\DeleteBulkAction $action, \Illuminate\Database\Eloquent\Collection $records) {
                            return DB::transaction(function () use ($action, $records) {
                                try {
                                    foreach ($records as $record) {
                                        // Hapus parameter terkait untuk setiap QuotationItem
                                        $record->quotationItemParameters()->delete();
                                        // Kemudian hapus QuotationItem itu sendiri
                                        $record->delete();
                                    }
                                    return true; // Beri tahu Filament bahwa penghapusan berhasil
                                } catch (\Exception $e) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Gagal menghapus item penawaran')
                                        ->body('Terjadi kesalahan: ' . $e->getMessage())
                                        ->send();
                                    return false; // Beri tahu Filament bahwa penghapusan gagal
                                }
                            });
                        }),
                ]),
            ]);
    }
}
