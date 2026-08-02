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
use App\Models\Enums\SampleCollectionTypeEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJob;
use App\Models\LabJobItem;
use App\Models\TestPackage;
use App\Services\LabJobItemService;
use App\Services\LabJobService;
use App\Services\SampleService;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
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
use Illuminate\Support\HtmlString;

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
        $sampleService = app(SampleService::class);
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
                ])->columnSpanFull()->columns(3),

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
                TextColumn::make('information')
                    ->label('Produk Uji')
                    ->state(fn($record) => new HtmlString("
        <div style='line-height:1.5'>
            <div><strong>Kode</strong> : {$record->code}</div>
            <div><strong>Matrix</strong> : {$record->description}</div>
            <div><strong>Regulasi</strong> : {$record->regulation_name}</div>
        </div>
    "))
                    ->html(),
                TextColumn::make('samples.code')
                    ->label('Sampel')
                    ->listWithLineBreaks()
                    ->limitList(5)
                    ->url(fn($record) => $record->samples->isNotEmpty()
                        ? SampleResource::getUrl('view', ['record' => $record->samples->first()])
                        : null)
                    ->expandableLimitedList(),
                TextColumn::make('parameterLabJobItems')
                    ->badge()
                    ->listWithLineBreaks()
                    ->limitList(5)
                    ->expandableLimitedList()
                    ->formatStateUsing(fn($state) => $state->parameter_code . " " . $state->parameter_price ?? Number::currency($state->parameter_price, 'RP.'))
                    ->color(fn($state) => ParameterStatusEnum::color($state->parameter_status))

                    ->label('Parameter Uji'),

                TextColumn::make('quantity_info')
                    ->label('Kuantitas')
                    ->state(fn($record) => new HtmlString("
                        <strong>{$record->quantity}</strong>
                        <span style='color:#6b7280'> {$record->unit}</span>
                    "))
                    ->html()
                    ->alignEnd(),
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
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_by')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->mutateDataUsing(function (
                        array $data,
                        LabJobItemService $labJobItemService
                    ): array {
                        $data['code'] = $labJobItemService
                            ->generateCode($this->ownerRecord);

                        return $data;
                    })
                    ->after(function (
                        LabJobItem $record,
                        LabJobItemService $labJobItemService
                    ) {

                        $labJobItemService
                            ->syncParameterLabJobItems($record);
                    })
                    ->databaseTransaction(),
            ])
            ->recordActions([

                ViewAction::make()->slideOver(),
                EditAction::make()
                    ->slideOver()
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
