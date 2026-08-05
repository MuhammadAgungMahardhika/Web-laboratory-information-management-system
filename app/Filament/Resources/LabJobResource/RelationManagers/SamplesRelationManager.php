<?php

namespace App\Filament\Resources\LabJobResource\RelationManagers;

use App\Filament\Resources\Samples\Actions\SampleAction;
use App\Filament\Resources\Samples\SampleResource;
use App\Filament\Resources\Samples\Tables\SamplesTable;
use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\SampleCollectionTypeEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJobItem;
use App\Models\Sample;
use App\Services\SampleService;
use Exception;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor\Actions\LinkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SamplesRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'samples';
    protected static ?string $label = "Sampel";
    protected static ?string $title = "Sampel";
    public const PERMISSION_COLLECTING_SAMPLE = 'collecting-sample';
    public const PERMISSION_RECEIVING_SAMPLE = 'receiving-sample';
    protected $listeners = ['refresh'];

    public function isReadOnly(): bool
    {
        return $this->ownerRecord->status !== JobStatusEnum::InProgress->value;
    }
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->status !== JobStatusEnum::PendingStart->value;
    }
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->samples->count();
    }

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }
    public function form(Schema $schema): Schema
    {
        $user = Auth::user();
        $personel = $user->personel;
        $sampleService  = app(SampleService::class);
        $ownerRecord = $this->ownerRecord;
        return  SampleResource::form($schema)
            ->components([
                Section::make([
                    Select::make('lab_job_item_id')
                        ->label('Produk Uji')
                        ->relationship('labJobItem', 'description_code', modifyQueryUsing: function (
                            $query
                        ) use ($ownerRecord) {
                            $ownerRecord->loadMissing('labJobItems');
                            return $query
                                ->where('group', 'A')
                                ->where('lab_job_id', $ownerRecord->id);
                        })
                        ->required()
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function ($state,  $set) use ($sampleService) {
                            if ($state) {
                                // Inisialisasi service
                                $labJobItem = LabJobItem::find($state);
                                $sampleCode = $sampleService->generateSampleCode($labJobItem);
                                $set('code', $sampleCode);
                            } else {
                                $set('code', null);
                            }
                        }),

                    TextInput::make('code')
                        ->label('Kode Sampel')
                        ->unique()
                        ->live()
                        ->disabled()
                        ->dehydrated()

                        ->required(),
                    Select::make('status')
                        ->label('Status')
                        ->searchable()
                        ->disabled()
                        ->dehydrated()
                        ->options(SampleStatusEnum::labels())
                        ->default(SampleStatusEnum::default())
                        ->required(),
                    Radio::make('collection_type')
                        ->label('Keterangan Lain')
                        ->default(SampleCollectionTypeEnum::default())
                        ->options(SampleCollectionTypeEnum::labels())
                        ->live()
                        ->inline(),
                ])->columnSpanFull()->columns(1)->visible(fn() => static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE))->inlineLabel(),
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('pengambilan')
                            ->label('PENGAMBILAN SAMPEL OLEH PPC')
                            ->columnSpanFull()
                            ->columns(2)
                            ->inlineLabel()
                            ->icon(Heroicon::OutlinedBeaker)
                            ->schema([
                                Select::make('collected_by_personel_id')
                                    ->relationship(
                                        'collectedByPersonel',
                                        'fullname',
                                    )
                                    ->label('Ppc')
                                    ->searchable()
                                    ->default(static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE) ? ($personel->id ?? null) : null)
                                    ->preload(),
                                DatePicker::make('collection_date')
                                    ->label('Tanggal Pengambilan')
                                    ->default(now()),
                                TimePicker::make('collection_time')
                                    ->label('Waktu Pengambilan')
                                    ->default(now()->format('H:i:s')),

                                TextInput::make('preservation_method')
                                    ->label('Metode Preservasi')
                                    ->maxLength(255),
                                TextInput::make('latitude'),
                                TextInput::make('longitude'),

                                Textarea::make('collection_location_desc')
                                    ->label('Lokasi Pengambilan'),
                                Textarea::make('collection_notes')
                                    ->label('Catatan Pengambilan'),

                            ])->visible(
                                fn(Get $get) => static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE)
                                    && SampleCollectionTypeEnum::tryFrom($get('collection_type')) === SampleCollectionTypeEnum::Collected
                            ),
                        Tab::make('penerimaan')
                            ->label('PENERIMAAN SAMPEL OLEH ADMIN')
                            ->icon(Heroicon::OutlinedInbox)
                            ->columnSpanFull()
                            ->columns(2)
                            ->inlineLabel()
                            ->schema([
                                Select::make('received_by_personel_id')
                                    ->relationship('receivedByPersonel', 'fullname')
                                    ->label('Penerima')
                                    ->default(static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE) ? ($personel->id ?? null) : null)
                                    ->searchable()
                                    ->preload(),
                                DatePicker::make('received_date')
                                    ->label('Tanggal Penerimaan')
                                    ->default(now()),
                                TimePicker::make('received_time')
                                    ->label('Waktu Penerimaan')
                                    ->default(now()->format('H:i:s')),
                                Textarea::make('received_condition_notes')
                                    ->label('Catatan Kondisi Penerimaan'),
                                TextInput::make('container_type')
                                    ->label('Jenis Wadah')
                                    ->maxLength(50)
                                    ->nullable(),
                                TextInput::make('container_quantity')
                                    ->label('Jumlah Wadah')

                                    ->numeric()
                                    ->default(1),
                                TextInput::make('sample_volume')
                                    ->label('Volume Sampel')
                                    ->maxLength(50)
                                    ->nullable(),
                            ])->visible(fn() => static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE)),
                    ])
                    ->columnSpanFull()->visible(fn(Get $get) => !is_null($get('code')))->activeTab(function (Get $get) {
                        return SampleCollectionTypeEnum::tryFrom($get('collection_type')) === SampleCollectionTypeEnum::Collected
                            ? 1 : 2;
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        $ownerStatus =  $this->ownerRecord->status;
        $sampleService  = app(SampleService::class);
        return SampleResource::table($table)
            ->modifyQueryUsing(function ($query) {
                return $query->with('collectedByPersonel', 'receivedByPersonel', 'labJobItem.labJob');
            })
            ->filters([
                SelectFilter::make('lab_job_item_id')
                    ->label('Nomor Produk Uji')
                    ->relationship('labJobItem', 'code')
                    ->searchable()
                    ->preload(),


            ], layout: FiltersLayout::Dropdown)
            ->headerActions([
                CreateAction::make()->after(
                    function (RelationManager $livewire) {
                        $livewire->dispatch('refresh');
                    }
                )->slideOver(),
            ])
            ->recordActions([
                ActionGroup::make([
                    SampleAction::downloadLabel(),
                    SampleAction::received(),
                    SampleAction::prepare(),
                ])->label('Aksi')->dropdownPlacement("right-top"),
                SampleAction::reopen()->after(
                    function (RelationManager $livewire) {
                        $livewire->dispatch('refresh');
                    }
                ),
                ViewAction::make()->slideOver()->extraModalFooterActions([
                    SampleAction::downloadLabel(),
                    SampleAction::received(),
                    SampleAction::prepare()
                ]),
                EditAction::make()->slideOver()->after(
                    function (RelationManager $livewire) {
                        $livewire->dispatch('refresh');
                    }
                )->authorize(fn() =>  $ownerStatus === JobStatusEnum::InProgress->value),
                LinkAction::make()->label('Detail')->url(fn(Sample $record) => SampleResource::getUrl('view', ['record' => $record->id]))->authorize(static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE) && static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE))->icon(HeroIcon::ArrowRightEndOnRectangle)->openUrlInNewTab(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->after(
                        function (RelationManager $livewire) {
                            $livewire->dispatch('refresh');
                        }
                    )->authorize(fn() =>  $ownerStatus === JobStatusEnum::InProgress->value),
                    BulkAction::make('Siapkan')
                        ->icon(Heroicon::OutlinedDocumentCheck)
                        ->color('info')
                        ->requiresConfirmation()
                        ->authorize($this->ownerRecord->status === JobStatusEnum::SamplingCompleted->value && static::isAuthorized(SampleAction::PERMISSION_PREPARE))
                        ->action(function (Collection $records) use ($sampleService) {
                            $successCount = 0;
                            $failedCount = 0;
                            foreach ($records as $record) {
                                try {
                                    DB::transaction(function () use ($sampleService, $record) {
                                        $sampleService->updateSampleStatus($record, SampleStatusEnum::Prepared);
                                    });

                                    $successCount++;
                                } catch (\Exception $e) {
                                    $failedCount++;
                                }
                            }
                            if ($successCount > 0) {
                                Notification::make()
                                    ->title("Berhasil menyiapkan sampel uji")
                                    ->body("{$successCount} sample berhasil untuk disiapkan.")
                                    ->success()
                                    ->send();
                            }
                            if ($failedCount > 0) {
                                Notification::make()
                                    ->title("Gagal menyiapkan sampel uji")
                                    ->body("{$failedCount} sample gagal untuk disiapkan.")
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->paginated(false);
    }
}
