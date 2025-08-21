<?php

namespace App\Filament\Resources\LabJobResource\RelationManagers;

use App\Filament\Resources\Samples\SampleResource;
use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\PositionEnum;
use App\Models\Enums\SampleStatusEnum;
use Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Tables\Grouping\Group;

class SamplesRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'samples';
    protected static ?string $label = "Sampel";
    protected static ?string $title = "Sampel";

    public function isReadOnly(): bool
    {
        return false;
    }
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->status === JobStatusEnum::InProgress->value;
    }
    public function form(Schema $schema): Schema
    {
        return  $schema
            ->components([
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
                    ->afterStateUpdated(function ($state, $set) {
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
                Wizard::make([
                    Step::make('INFORMASI PENGAMBILAN')
                        ->columnSpanFull()
                        ->schema([
                            Select::make('collected_by_personel_id')
                                ->relationship(
                                    'collectedByPersonel',
                                    'fullname',
                                    modifyQueryUsing: fn($query) => $query->whereHas('position', fn($query) => $query->whereIn('name', [PositionEnum::KepalaPpc->value, PositionEnum::Ppc->value]))
                                        ->whereHas('labJobPersonels', fn($q) => $q->where('lab_job_id', $this->ownerRecord->id))
                                )
                                ->label('Ppc')
                                ->searchable()
                                ->preload(),
                            TextInput::make('sample_code')
                                ->label('Kode Sampel')
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
                        ])->columns(4),
                    Step::make('INFORMASI PENERIMAAN')
                        ->columnSpanFull()
                        ->schema([
                            Select::make('received_by_personel_id')
                                ->relationship('receivedByPersonel', 'fullname', modifyQueryUsing: fn($query) => $query->whereHas('position', fn($query) => $query->where('name', PositionEnum::Administrator->value)))
                                ->label('Penerima')
                                ->default(Auth::user()->id)
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
                        ])->columns(4),
                ])->columnSpanFull(),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('labJobItem.description')
                    ->label(''),
            ])
            ->defaultGroup('labJobItem.description')

            ->columns([
                TextColumn::make('sample_code')
                    ->label('Kode Sampel')
                    ->searchable(),

                TextColumn::make('collectedByPersonel.fullname')
                    ->label('Ppc')
                    ->sortable(),
                TextColumn::make('receivedByPersonel.fullname')
                    ->label('Penerima')
                    ->sortable(),
                TextColumn::make('collection_date')
                    ->label('Tanggal Pengambilan')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('collection_time')
                    ->label('Waktu Pengambilan')
                    ->alignEnd()
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('latitude')
                    ->searchable(),
                TextColumn::make('longitude')
                    ->searchable(),
                TextColumn::make('container_type')
                    ->label('Jenis Wadah')
                    ->searchable(),
                TextColumn::make('container_quantity')
                    ->label('Jumlah Wadah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sample_volume')
                    ->label('Volume Sampel')
                    ->searchable(),
                TextColumn::make('preservation_method')
                    ->label('Metode Preservasi')
                    ->searchable(),
                TextColumn::make('received_date')
                    ->label('Tanggal Penerimaan')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('received_time')
                    ->label('Waktu Penerimaan')
                    ->alignEnd()
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => SampleStatusEnum::labels()[$state]),
                TextColumn::make('created_by')
                    ->searchable(),
                TextColumn::make('updated_by')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
