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
use Filament\Tables\Enums\RecordActionsPosition;
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

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }
    public function form(Schema $schema): Schema
    {
        $user = Auth::user();
        $personel = $user->personel;
        return  SampleResource::form($schema)
            ->components([
                Section::make([
                    Select::make('lab_job_item_id')
                        ->label('Item Job')
                        ->relationship('labJobItem', 'description', modifyQueryUsing: function ($query) {
                            return $query
                                ->where('group', 'A')
                                ->where('lab_job_id', $this->ownerRecord->id);
                        })
                        ->required()
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function ($state,  $set) {
                            if ($state) {
                                // Inisialisasi service
                                $sampleService = new \App\Services\SampleService();
                                $labJobItem = LabJobItem::find($state);
                                $sampleCode = $sampleService->generateSampleCode($labJobItem);
                                $set('sample_code', $sampleCode);
                            } else {
                                $set('sample_code', null);
                            }
                        }),
                    TextInput::make('sample_code')
                        ->label('Kode Sampel')
                        ->unique()
                        ->live()
                        ->readOnly() // Kode sampel tidak bisa diubah manual
                        ->required(),
                    Select::make('status')
                        ->label('Status')
                        ->options(SampleStatusEnum::labels())
                        ->default(SampleStatusEnum::default())
                        ->required(),
                    Radio::make('collection_type')
                        ->label('Keterangan Lain')
                        ->options(SampleCollectionTypeEnum::labels())
                        ->live()
                        ->default(SampleCollectionTypeEnum::default()->value)
                        ->inline(),
                ])->columnSpanFull()->visible(fn() =>  static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE))->columns(4),
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('pengambilan')
                            ->label('PENGAMBILAN SAMPEL OLEH PPC')
                            ->columnSpanFull()

                            ->icon(Heroicon::OutlinedBeaker)
                            ->schema([
                                Select::make('collected_by_personel_id')
                                    ->relationship(
                                        'collectedByPersonel',
                                        'fullname',
                                        modifyQueryUsing: fn($query) =>
                                        $query->whereHas('labJobPersonels', fn($q) => $q->where('lab_job_id', $this->ownerRecord->id))
                                    )
                                    ->label('Ppc')
                                    ->searchable()
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
                                Textarea::make('collection_notes')
                                    ->label('Catatan Pengambilan')
                                    ->columnSpan(2),
                                Section::make('Lokasi pengambilan')
                                    ->columns(1)
                                    ->columnSpan(2)
                                    ->schema([
                                        Textarea::make('collection_location_desc')
                                            ->label('Lokasi Pengambilan'),
                                        TextInput::make('latitude'),
                                        TextInput::make('longitude'),
                                    ])->inlineLabel(),

                            ])->columns(4)->visible(
                                fn(Get $get) =>   static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE)
                                    && SampleCollectionTypeEnum::tryFrom($get('collection_type')) === SampleCollectionTypeEnum::Collected
                            ),
                        Tab::make('penerimaan')
                            ->label('PENERIMAAN SAMPEL OLEH ADMIN')
                            ->icon(Heroicon::OutlinedInbox)
                            ->columnSpanFull()
                            ->schema([
                                Select::make('received_by_personel_id')
                                    ->relationship('receivedByPersonel', 'fullname')
                                    ->label('Penerima')
                                    ->default(static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE) ? ($personel->id ?? null) : null)
                                    ->searchable()
                                    ->preload(),
                                DatePicker::make('received_date')
                                    ->label('Tanggal Penerimaan')
                                    ->default(now())
                                    ->required(),
                                TimePicker::make('received_time')
                                    ->label('Waktu Penerimaan')
                                    ->default(now()->format('H:i:s'))
                                    ->required(),
                                Textarea::make('received_condition_notes')
                                    ->label('Catatan Kondisi Penerimaan')
                                    ->columnSpan(2),
                                Section::make('Wadah dan Volume')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('container_type')
                                            ->label('Jenis Wadah')
                                            ->maxLength(50)
                                            ->nullable(),
                                        TextInput::make('container_quantity')
                                            ->label('Jumlah Wadah')
                                            ->required()
                                            ->numeric()
                                            ->default(1),
                                        TextInput::make('sample_volume')
                                            ->label('Volume Sampel')
                                            ->maxLength(50)
                                            ->nullable(),
                                    ])->columnSpan(2)
                                    ->inlineLabel(),
                            ])->columns(4)->visible(fn() => static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE)),
                    ])
                    ->columnSpanFull()->visible(fn(Get $get) => !is_null($get('sample_code')))->activeTab(function (Get $get) {
                        return SampleCollectionTypeEnum::tryFrom($get('collection_type')) === SampleCollectionTypeEnum::Collected
                            ? 1 : 2;
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return SampleResource::table($table)
            ->headerActions([
                CreateAction::make()->after(
                    function (RelationManager $livewire) {
                        $livewire->dispatch('refresh');
                    }
                ),
            ])
            ->recordActions([
                SampleAction::downloadLabel($this->ownerRecord),
                SampleAction::prepare($this->ownerRecord),
                EditAction::make(),
                ViewAction::make(),
                LinkAction::make('detail')->label('Detail')->url(fn(Sample $record) => SampleResource::getUrl('view', ['record' => $record->id]))->authorize(static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE) && static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE)),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->after(
                        function (RelationManager $livewire) {
                            $livewire->dispatch('refresh');
                        }
                    ),
                    BulkAction::make('Siapkan')
                        ->icon(Heroicon::OutlinedDocumentCheck)
                        ->color('info')
                        ->visible(fn() => $this->ownerRecord->status === JobStatusEnum::SamplingCompleted->value)
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $sampleService = new SampleService();
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
