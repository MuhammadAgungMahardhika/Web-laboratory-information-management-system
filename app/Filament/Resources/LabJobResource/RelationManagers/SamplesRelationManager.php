<?php

namespace App\Filament\Resources\LabJobResource\RelationManagers;


use App\Filament\Resources\Samples\Tables\SamplesTable;
use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\PositionEnum;
use App\Models\Enums\SampleStatusEnum;
use Auth;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;

class SamplesRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'samples';
    protected static ?string $label = "Sampel";
    protected static ?string $title = "Sampel";

    public function isReadOnly(): bool
    {
        return $this->ownerRecord->status !== JobStatusEnum::InProgress->value;
    }
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->status !== JobStatusEnum::PendingStart->value;
    }
    public function form(Schema $schema): Schema
    {
        $user = Auth::user();
        $personel = $user->personel;
        $isLabJobPersonel = $personel->labJobPersonels()->where('lab_job_id', $this->ownerRecord->id)->exists();
        $isCollector = $user->can('collecting-sample');
        $isReceiver = $user->can('receiving-sample');
        return  $schema
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
                                $labJobItem = $this->ownerRecord->labJobItems()->find($state);
                                $sampleCode = $sampleService->generateSampleCode($labJobItem);
                                $set('sample_code', $sampleCode);
                            } else {
                                $set('sample_code', null);
                            }
                        }),
                    Select::make('status')
                        ->options(SampleStatusEnum::labels())
                        ->default(SampleStatusEnum::default())
                        ->required(),
                ])->columnSpanFull()->visible(fn() => $isCollector)->columns(2),
                Wizard::make([
                    Step::make('PENGAMBILAN OLEH PPC')
                        ->columnSpanFull()
                        ->schema([
                            Select::make('collected_by_personel_id')
                                ->relationship(
                                    'collectedByPersonel',
                                    'fullname',
                                    modifyQueryUsing: fn($query) =>
                                    $query->whereHas('labJobPersonels', fn($q) => $q->where('lab_job_id', $this->ownerRecord->id))
                                )
                                ->default($isLabJobPersonel ? ($personel->id ?? null) : null)
                                ->label('Ppc')
                                ->searchable()
                                ->preload(),
                            TextInput::make('sample_code')
                                ->label('Kode Sampel')
                                ->unique()
                                ->readOnly() // Kode sampel tidak bisa diubah manual
                                ->required(),
                            DatePicker::make('collection_date')
                                ->label('Tanggal Pengambilan')
                                ->default(now())
                                ->required(),
                            TimePicker::make('collection_time')
                                ->label('Waktu Pengambilan')
                                ->default(now()->format('H:i:s'))
                                ->required(),
                            Textarea::make('collection_location_desc')
                                ->label('Lokasi Pengambilan'),
                            TextInput::make('latitude'),
                            TextInput::make('longitude'),
                            TextInput::make('preservation_method')
                                ->label('Metode Preservasi')
                                ->maxLength(255)
                                ->nullable(),
                            Textarea::make('collection_notes')
                                ->label('Catatan Pengambilan')
                                ->columnSpanFull(),
                            Section::Make('Wadah dan Volume')
                                ->columns(3)
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
                                ])->columnSpanFull(),
                        ])->columns(4)->visible(fn() =>  $isCollector),
                    Step::make('PENERIMAAN OLEH ADMIN')
                        ->columnSpanFull()
                        ->schema([
                            Select::make('received_by_personel_id')
                                ->relationship('receivedByPersonel', 'fullname')
                                ->label('Penerima')
                                ->default($isReceiver ? ($personel->id ?? null) : null)
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
                                ->columnSpanFull(),
                        ])->columns(4)->visible(fn(Get $get) => $isReceiver && !is_null($get('sample_code'))),
                ])->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return SamplesTable::configure($table)
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
