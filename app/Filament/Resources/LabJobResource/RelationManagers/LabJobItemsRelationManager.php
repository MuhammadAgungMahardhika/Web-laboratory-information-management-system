<?php

namespace App\Filament\Resources\LabJobResource\RelationManagers;

use App\Filament\Resources\Samples\SampleResource;
use App\Models\Enums\JobStatusEnum;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
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
use App\Models\LabJob;
use App\Models\LabJobItem;
use App\Models\TestPackage;
use App\Services\LabJobItemService;
use App\Services\LabJobService;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class LabJobItemsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'labJobItems';
    protected static ?string $label = 'Produk Uji';
    protected static ?string $title = "Produk Uji";


    public static function canCreateForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->status === JobStatusEnum::AnalysisCompleted->value;
    }

    public static function canUpdateForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->status === JobStatusEnum::AnalysisCompleted->value;
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->labJobItems->where('group', 'A')->count();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('group')
                    ->default('A'), // Field ini tidak perlu disimpan ke DB
                // -------------------------------
                Section::make([
                    Select::make('test_package_id')
                        ->label('Produk Uji')
                        ->relationship('testPackage', 'name', modifyQueryUsing: fn(Builder $query) => $query->with('regulation'))
                        ->getOptionLabelFromRecordUsing(
                            fn(Model $record) =>
                            $record->name .
                                ($record->regulation ? " ({$record->regulation->name})" : '')
                        )
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set) {
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
                        })->preload(),

                    TextInput::make('description')
                        ->label('Keterangan')
                        ->disabled()
                        ->dehydrated()
                        ->autocomplete(false)
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Deskripsi akan otomatis terisi dari Produk Uji'),
                    TextInput::make('regulation_name')
                        ->label('Nama Regulasi')
                        ->disabled()
                        ->dehydrated()
                        ->autocomplete(false)
                        ->maxLength(255),

                    Hidden::make('regulation_id'),
                    Select::make('parameters')
                        ->searchable()
                        ->multiple()
                        ->columnSpanFull()
                        ->label('Parameter Uji')
                        ->relationship('parameters', 'long_name_standard_notes')
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
                        ->disabled()
                        ->dehydrated()
                        ->prefix('Rp.')
                        ->required()
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
                        ->default(0),
                ])->columnSpanFull()->columns(4)->visible(fn(Get $get) => $get('group') !== 'A')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->with('parameterLabJobItems');
            })
            ->recordTitleAttribute('description')
            ->paginated(false)
            ->columns([
                TextColumn::make('description')
                    ->label('Deskripsi'),
                TextColumn::make('regulation_name')
                    ->label('Regulasi'),
                TextColumn::make('parameterLabJobItems')
                    ->badge()
                    ->listWithLineBreaks()
                    ->limitList(5)
                    ->expandableLimitedList()
                    ->formatStateUsing(fn($state) => $state->parameter_code . " " . $state->parameter_price ?? Number::currency($state->parameter_price, 'RP.'))
                    ->color(fn($state) => ParameterStatusEnum::color($state->parameter_status))

                    ->label('Parameter Uji'),

                TextColumn::make('quantity')

                    ->alignEnd()
                    ->label('Kuantitas'),
                TextColumn::make('unit')

                    ->label('Satuan'),
                TextColumn::make('price')
                    ->label('Harga')
                    ->alignEnd()

                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('item_total')
                    ->label('Harga Total')
                    ->alignEnd()

                    ->money('IDR'),
                TextColumn::make('location')

                    ->label('Lokasi pengambilan sampel')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('created_by')

                    ->toggleable(),
                TextColumn::make('updated_by')

                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('resetToQuotationSnapshot')
                    ->label('Kembalikan Rincian Lab Job')
                    ->icon(Heroicon::ArrowUturnLeft)
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan Rincian Lab Job?')
                    ->modalDescription('Ini akan menghapus semua rincian pekerjaan saat ini dan menggantinya dengan rincian dari penawaran awal.')
                    ->modalSubmitActionLabel('Ya, Kembalikan')
                    ->action(function (LabJobService $labJobService) {
                        try {
                            $record = $this->ownerRecord; // Ambil record induk
                            DB::transaction(function () use ($record, $labJobService) {
                                $labJobService->resetToQuotationSnapshot($record);
                            });
                            return Notification::make()->title('Rincian pekerjaan berhasil dikembalikan.')->success()->send();
                        } catch (\Exception $e) {
                            Log::error('Gagal mengembalikan rincian pekerjaan: ' . $e->getMessage());
                            return Notification::make()->title('Gagal mengembalikan rincian pekerjaan.')->danger()->body('Terjadi kesalahan: ' . $e->getMessage())->send();
                        }
                    })->visible(fn() => !$this->isReadOnly() && $this->ownerRecord->status === JobStatusEnum::PendingStart->value),
                CreateAction::make()
                    ->after(function (LabJobItem $record, array $data) {
                        // Inisialisasi service
                        $LabJobItemService = new LabJobItemService();
                        $LabJobItemService->syncParameterLabJobItems($record);
                    })->databaseTransaction(),
            ])
            ->recordActions([
                Action::make('manageSamples')
                    ->label('Kelola Sampel')
                    ->icon('heroicon-o-beaker')
                    ->url(function (LabJobItem $record) {
                        if ($record->samples()->exists()) {
                            return SampleResource::getUrl('index', [
                                'filters[labJobItem][lab_job_id][value]=' => $record->id,
                            ]);
                        }

                        return SampleResource::getUrl('create', [
                            'lab_job_item_id' => $record->id,
                        ]);
                    }),
                EditAction::make()
                    ->after(function (LabJobItem $record, array $data) {
                        // Inisialisasi service
                        $LabJobItemService = new LabJobItemService();
                        $LabJobItemService->syncParameterLabJobItems($record);
                    })->databaseTransaction(),
                DeleteAction::make()
                    ->using(function (DeleteAction $action, LabJobItem $record) {
                        return DB::transaction(function () use ($action, $record) {
                            try {
                                // Hapus parameterLabJobItem terkait terlebih dahulu
                                $record->parameterLabJobItems()->delete(); // Menggunakan relasi hasMany
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
                                        // Hapus parameter terkait untuk setiap LabJobItem
                                        $record->parameterLabJobItems()->delete();
                                        // Kemudian hapus LabJobItem itu sendiri
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
