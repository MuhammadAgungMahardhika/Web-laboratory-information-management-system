<?php

namespace App\Filament\Resources\QuotationResource\RelationManagers;

use App\Models\Enums\ParameterStatusEnum;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\TestPackage;
use App\Models\QuotationItem; // Import model QuotationItem

use App\Services\QuotationItemService;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

use function Filament\Support\format_money;

class QuotationItemRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected  bool $isCachingForms = true;
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
                        $set('parameters', []);
                        if ($state) {
                            $testPackage = TestPackage::find($state);
                            if ($testPackage) {
                                $set('description', $testPackage->name);
                                $set('price', $testPackage->price);
                                if ($testPackage->regulation) {
                                    $set('regulation_id', $testPackage->regulation->id);
                                    $set('regulation_name', $testPackage->regulation->name);
                                }
                                if ($testPackage->parameters) {
                                    $set('parameters', $testPackage->parameters->pluck('id')->toArray());
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
                        ->default('persampel')
                        ->datalist([
                            'persampel',
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
                Select::make('parameters')
                    ->searchable()
                    ->multiple()
                    ->relationship('parameters', 'name')

                    ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->with('parameterQuotationItems');
            })
            ->recordTitleAttribute('description')
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->size(TextColumnSize::Small),
                Tables\Columns\TextColumn::make('regulation_name')
                    ->label('Regulasi')
                    ->size(TextColumnSize::Small),
                Tables\Columns\TextColumn::make('parameterQuotationItems')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->parameter_name . " " . Number::currency($state->parameter_default_price, 'RP.'))
                    ->color(fn($state) => ParameterStatusEnum::color($state->parameter_status))
                    ->size(TextColumnSize::Small)
                    ->label('Parameter'),

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
                                    $total += ($record->quantity * $record->price);
                                }
                                return Number::currency($total, 'IDR');
                            })
                    ),

                Tables\Columns\TextColumn::make('location')
                    ->size(TextColumnSize::Small)
                    ->label('Lokasi pengambilan sampel')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function (QuotationItem $record, array $data) {
                        // Inisialisasi service
                        $quotationItemService = new QuotationItemService();
                        $quotationItemService->syncParameterQuotationItems($record);
                    })->databaseTransaction(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (QuotationItem $record, array $data) {
                        // Inisialisasi service
                        $quotationItemService = new QuotationItemService();
                        $quotationItemService->syncParameterQuotationItems($record);
                    })->databaseTransaction(),
                Tables\Actions\DeleteAction::make()
                    ->using(function (Tables\Actions\DeleteAction $action, QuotationItem $record) {
                        return DB::transaction(function () use ($action, $record) {
                            try {
                                // Hapus parameterQuotationItem terkait terlebih dahulu
                                $record->parameterQuotationItems()->delete(); // Menggunakan relasi hasMany
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
                                        $record->parameterQuotationItems()->delete();
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
