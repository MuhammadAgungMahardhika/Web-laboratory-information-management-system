<?php

namespace App\Filament\Resources\QuotationResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\TextSize;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Exception;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Enums\ParameterStatusEnum;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\TestPackage;
use App\Models\QuotationItem; // Import model QuotationItem
use App\Models\Regulation;
use App\Services\QuotationItemService;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Model;
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
    public function form(Schema $schema): Schema
    {

        return $schema
            ->components([
                // --- FIELD PEMILIH JENIS ITEM ---
                Select::make('group')
                    ->label('Jenis Item')
                    ->options([
                        'A' => 'Paket Pengujian',
                        'B' => 'Biaya Pengambilan Sampel',
                        'C' => 'Lainnya',
                    ])
                    ->required()
                    ->default('A')
                    ->reactive(), // Field ini tidak perlu disimpan ke DB
                // -------------------------------
                Section::make([
                    Select::make('test_package_id')
                        ->label('Paket Pengujian')
                        ->relationship('testPackage', 'name', modifyQueryUsing: fn(Builder $query) => $query->with('regulation'))
                        ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->name} ({$record->regulation->name})")
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function ($state, Set $set) {
                            $set('description', null);
                            $set('price', null);
                            $set('regulation_id', null);
                            $set('regulation_name', null);
                            $set('parameters', []);
                            if ($state) {
                                $testPackage = TestPackage::with('sampleMatric', 'regulation', 'parameters')->find($state);
                                if ($testPackage) {
                                    $set('description', $testPackage->sampleMatric->name);
                                    $set('price', $testPackage->price);
                                    if ($testPackage->regulation) {
                                        $set('regulation_id', $testPackage->regulation_id);
                                        $set('regulation_name', $testPackage->regulation->name);
                                    }
                                    if ($testPackage->parameters) {
                                        $set('parameters', $testPackage->parameters->pluck('id')->toArray());
                                    }
                                }
                            }
                        })->preload(),

                    TextInput::make('description')
                        ->label('Keterangan')
                        ->autocomplete(false)
                        ->datalist([
                            'Engineer dan Mobilisasi'
                        ])
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Deskripsi akan otomatis terisi dari Paket Pengujian'),
                    TextInput::make('regulation_name')
                        ->label('Nama Regulasi')
                        ->autocomplete(false)
                        ->maxLength(255),

                    Hidden::make('regulation_id')->afterStateUpdated(function ($state, Set $set) {
                        $set('regulation_name', null);
                        if ($state) {
                            $regulation = Regulation::find($state);
                            if ($regulation) {
                                $set('regulation_name', $regulation->name);
                            }
                        }
                    }),
                    Select::make('parameters')
                        ->searchable()
                        ->multiple()
                        ->relationship('parameters', 'name')
                        ->preload(),

                    TextInput::make('quantity')
                        ->label('Jumlah')
                        ->numeric()
                        ->required()
                        ->default(1),
                    TextInput::make('unit')
                        ->label('Satuan')
                        ->required()
                        ->autocomplete(false)
                        ->maxLength(50),
                    TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->prefix('Rp.')
                        ->required()
                        ->default(0)
                        ->step(500),
                    TextInput::make('location')
                        ->label('Lokasi Pengambilan Sampel')
                        ->maxLength(100)
                        ->nullable(),
                ])->columnSpanFull()->columns(3)->visible(fn(Get $get) => $get('group') === 'A'),
                Section::make([
                    TextInput::make('description')
                        ->label('Keterangan')
                        ->autocomplete(false)
                        ->datalist([
                            'Engineer dan Mobilisasi',
                        ])
                        ->required()
                        ->maxLength(255)
                        ->placeholder(fn(Get $get) => match ($get('group')) {
                            'B' => 'Deskripsi untuk biaya pengambilan sampel',
                            'C' => 'Deskripsi untuk item lainnya',
                            default => ''
                        }),
                    TextInput::make('quantity')
                        ->label('Jumlah')
                        ->numeric()
                        ->autocomplete(false)
                        ->required()
                        ->default(1),
                    TextInput::make('unit')
                        ->label('Satuan')
                        ->datalist(function (Get $get) {
                            $itemTypeSelector = $get('group');
                            if ($itemTypeSelector === 'B') {
                                return [
                                    'Hari',
                                    'Jam'
                                ];
                            } else {
                                return [
                                    'Sampel',
                                    'Ls'
                                ];
                            }
                        })
                        ->required()
                        ->autocomplete(false)
                        ->maxLength(50),
                    TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->required()
                        ->prefix('Rp.')
                        ->default(0)
                        ->step(500),
                ])->columnSpanFull()->columns(4)->visible(fn(Get $get) => $get('group') !== 'A')
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
            ->groups([
                Group::make('group')
                    ->label(''),
            ])
            ->defaultGroup('group')
            ->columns([
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->size(TextSize::Small),
                TextColumn::make('regulation_name')
                    ->label('Regulasi')
                    ->size(TextSize::Small),
                TextColumn::make('parameterQuotationItems')
                    ->badge()
                    ->listWithLineBreaks()
                    ->formatStateUsing(fn($state) => $state->parameter_name . " " . Number::currency($state->parameter_default_price, 'RP.'))
                    ->color(fn($state) => ParameterStatusEnum::color($state->parameter_status))
                    ->size(TextSize::Small)
                    ->label('Parameter'),

                TextColumn::make('quantity')
                    ->size(TextSize::Small)
                    ->alignEnd()
                    ->label('Kuantitas'),
                TextColumn::make('unit')
                    ->size(TextSize::Small)
                    ->label('Satuan'),
                TextColumn::make('price')
                    ->label('Harga')
                    ->alignEnd()
                    ->size(TextSize::Small)
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('item_total')
                    ->label('Harga Total')
                    ->alignEnd()
                    ->size(TextSize::Small)
                    ->money('IDR'),
                TextColumn::make('location')
                    ->size(TextSize::Small)
                    ->label('Lokasi pengambilan sampel')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->after(function (QuotationItem $record, array $data) {
                        // Inisialisasi service
                        $quotationItemService = new QuotationItemService();
                        $quotationItemService->syncParameterQuotationItems($record);
                    })->databaseTransaction(),
            ])
            ->recordActions([
                EditAction::make()
                    ->after(function (QuotationItem $record, array $data) {
                        // Inisialisasi service
                        $quotationItemService = new QuotationItemService();
                        $quotationItemService->syncParameterQuotationItems($record);
                    })->databaseTransaction(),
                DeleteAction::make()
                    ->using(function (DeleteAction $action, QuotationItem $record) {
                        return DB::transaction(function () use ($action, $record) {
                            try {
                                // Hapus parameterQuotationItem terkait terlebih dahulu
                                $record->parameterQuotationItems()->delete(); // Menggunakan relasi hasMany
                                $record->delete();
                                return true; // Beri tahu Filament bahwa penghapusan berhasil
                            } catch (Exception $e) {
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->using(function (DeleteBulkAction $action, Collection $records) {
                            return DB::transaction(function () use ($action, $records) {
                                try {
                                    foreach ($records as $record) {
                                        // Hapus parameter terkait untuk setiap QuotationItem
                                        $record->parameterQuotationItems()->delete();
                                        // Kemudian hapus QuotationItem itu sendiri
                                        $record->delete();
                                    }
                                    return true; // Beri tahu Filament bahwa penghapusan berhasil
                                } catch (Exception $e) {
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
