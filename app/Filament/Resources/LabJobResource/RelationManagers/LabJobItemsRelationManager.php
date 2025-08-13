<?php

namespace App\Filament\Resources\LabJobResource\RelationManagers;

use App\Models\Enums\ParameterStatusEnum;
use App\Models\LabJobItem;
use App\Models\TestPackage;
use App\Services\LabJobItemService;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Notification;

class LabJobItemsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'labJobItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    Select::make('parameters')
                        ->searchable()
                        ->multiple()
                        ->relationship('parameters', 'name')
                        ->preload(),

                    Forms\Components\TextInput::make('quantity')
                        ->label('Jumlah')
                        ->numeric()
                        ->required()
                        ->default(1),
                    Forms\Components\TextInput::make('unit')
                        ->label('Satuan')
                        ->required()
                        ->autocomplete(false)
                        ->maxLength(50),
                    Forms\Components\TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->prefix('Rp.')
                        ->required()
                        ->default(0)
                        ->step(500),
                    Forms\Components\TextInput::make('location')
                        ->label('Lokasi Pengambilan Sampel')
                        ->maxLength(100)
                        ->nullable(),
                ])->columns(3)->visible(fn(Get $get) => $get('group') === 'A'),
                Section::make([
                    Forms\Components\TextInput::make('description')
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
                    Forms\Components\TextInput::make('quantity')
                        ->label('Jumlah')
                        ->numeric()
                        ->autocomplete(false)
                        ->required()
                        ->default(1),
                    Forms\Components\TextInput::make('unit')
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
                    Forms\Components\TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->required()
                        ->prefix('Rp.')
                        ->default(0)
                        ->step(500),
                ])->columns(4)->visible(fn(Get $get) => $get('group') !== 'A')
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
            ->groups([
                Group::make('group')
                    ->label(''),
            ])
            ->defaultGroup('group')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->size(TextColumnSize::Small),
                Tables\Columns\TextColumn::make('regulation_name')
                    ->label('Regulasi')
                    ->size(TextColumnSize::Small),
                Tables\Columns\TextColumn::make('parameterLabJobItems')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->parameter_name . " " . Number::currency($state->parameter_default_price, 'RP.'))
                    ->color(fn($state) => ParameterStatusEnum::color($state->parameter_status))
                    ->size(TextColumnSize::Small)
                    ->label('Parameter'),

                Tables\Columns\TextColumn::make('quantity')
                    ->size(TextColumnSize::Small)
                    ->alignEnd()
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
                Tables\Columns\TextColumn::make('item_total')
                    ->label('Harga Total')
                    ->alignEnd()
                    ->size(TextColumnSize::Small)
                    ->money('IDR'),
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
                    ->after(function (LabJobItem $record, array $data) {
                        // Inisialisasi service
                        $LabJobItemService = new LabJobItemService();
                        $LabJobItemService->syncParameterLabJobItems($record);
                    })->databaseTransaction(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (LabJobItem $record, array $data) {
                        // Inisialisasi service
                        $LabJobItemService = new LabJobItemService();
                        $LabJobItemService->syncParameterLabJobItems($record);
                    })->databaseTransaction(),
                Tables\Actions\DeleteAction::make()
                    ->using(function (Tables\Actions\DeleteAction $action, LabJobItem $record) {
                        return DB::transaction(function () use ($action, $record) {
                            try {
                                // Hapus parameterLabJobItem terkait terlebih dahulu
                                $record->parameterLabJobItems()->delete(); // Menggunakan relasi hasMany
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
                                        // Hapus parameter terkait untuk setiap LabJobItem
                                        $record->parameterLabJobItems()->delete();
                                        // Kemudian hapus LabJobItem itu sendiri
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
