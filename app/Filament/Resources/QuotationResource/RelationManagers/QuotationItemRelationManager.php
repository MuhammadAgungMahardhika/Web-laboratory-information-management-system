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
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class QuotationItemRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'quotationItems';
    protected static ?string $label = 'Detail penawaran';
    protected static ?string $title = "Detail penawaran";

    public function form(Schema $schema): Schema
    {

        return $schema
            ->components([
                // --- FIELD PEMILIH JENIS ITEM ---
                Radio::make('group')
                    ->label('Jenis Item')
                    ->options([
                        'A' => 'A. Produk Uji',
                        'B' => 'B. Biaya Pengambilan Sampel',
                        'C' => 'C. Lainnya',
                    ])
                    ->inline()
                    ->afterStateUpdated(function ($state, Set $set) {
                        if ($state === 'A') {
                            $set('unit', 'Titik');
                        } else if ($state === 'B') {
                            $set('unit', 'Hari');
                        } else {
                            $set('unit', null);
                        }
                    })
                    ->required()
                    ->columnSpanFull()
                    ->default('A')
                    ->reactive(), // Field ini tidak perlu disimpan ke DB
                // -------------------------------
                Section::make([
                    Select::make('test_package_id')
                        ->label('Produk Uji')
                        // ->required()
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
                        ->required()
                        ->disabled(fn(Get $get) => $get('group') === 'A')
                        ->dehydrated()
                        ->maxLength(255)
                        ->placeholder('Deskripsi akan otomatis terisi dari Produk Uji'),
                    TextInput::make('regulation_name')
                        ->label('Regulasi')
                        ->disabled()
                        ->dehydrated()
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
                        ->relationship('parameters', 'code_standard_notes')
                        ->preload(),

                    TextInput::make('quantity')
                        ->label('Jumlah')
                        ->numeric()
                        ->required()
                        ->default(1),
                    Select::make('unit')
                        ->label('Satuan')
                        ->required()
                        ->searchable()
                        ->default(fn(Get $get) => $get('group') === 'A' ? 'Titik' : '')
                        ->options([
                            'Titik' => 'Titik',
                            'Hari' => 'Hari',
                            'Ls' => 'Ls',
                        ]),
                    TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->prefix('Rp.')
                        ->required()
                        ->readOnly()
                        ->default(0),
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
                    Select::make('unit')
                        ->label('Satuan')
                        ->required()
                        ->reactive()
                        ->searchable()
                        ->default(fn(Get $get) => $get('group') === 'B' ? 'Hari' : '')
                        ->options([
                            'Titik' => 'Titik',
                            'Hari' => 'Hari',
                            'Ls' => 'Ls',
                        ]),
                    TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->required()
                        ->prefix('Rp.')
                        ->default(0),
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
                    ->label('Group')
                    ->titlePrefixedWithLabel(false),
            ])
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
                    ->formatStateUsing(
                        fn($state) =>
                        $state->parameter_standard_notes
                            ? $state->parameter_code . ' (' . $state->parameter_standard_notes . ')'
                            : $state->parameter_code
                    )
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
                    ->summarize(
                        Summarizer::make()
                            ->prefix('Total : ')
                            ->using(
                                fn(QueryBuilder $query): string =>
                                // Hitung total dari kuantitas * harga satuan untuk semua item yang difilter
                                $query->sum(DB::raw('quantity * price'))
                            )
                            ->money('IDR')
                    )
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
