<?php

namespace App\Filament\Resources\LabJobResource\RelationManagers;

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
    protected static ?string $label = 'Detail Job';
    protected static ?string $title = "Detail Job";


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
                        ->label('Paket Pengujian')
                        ->relationship('testPackage', 'name')
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

                    Hidden::make('regulation_id'),
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
                $query->with('parameterLabJobItems');
            })
            ->recordTitleAttribute('description')
            ->paginated(false)
            ->columns([
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->size(TextSize::Small),
                TextColumn::make('regulation_name')
                    ->label('Regulasi')
                    ->size(TextSize::Small),
                TextColumn::make('parameterLabJobItems')
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
                TextColumn::make('created_by')
                    ->size(TextSize::Small)
                    ->toggleable(),
                TextColumn::make('updated_by')
                    ->size(TextSize::Small)
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('resetToQuotationSnapshot')
                    ->label('Kembalikan Rincian Pekerjaan')
                    ->icon(Heroicon::ArrowUturnLeft)
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan Rincian Pekerjaan?')
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
