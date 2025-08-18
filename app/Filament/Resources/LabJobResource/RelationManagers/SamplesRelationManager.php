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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
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
        return false;
    }
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->status === JobStatusEnum::InProgress->value;
    }
    public function form(Schema $schema): Schema
    {
        $ownerRecord = $this->ownerRecord;
        return  $schema
            ->components([
                Select::make('lab_job_item_id')
                    ->label('Item Job')
                    ->relationship('labJobItem', 'description', modifyQueryUsing: function ($query) use ($ownerRecord) {
                        return $query
                            ->where('group', 'A')
                            ->where('lab_job_id', $ownerRecord->id);
                    })
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('sample_matric_id')
                    ->label('Matric Sampel')
                    ->relationship('sampleMatric', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Wizard::make([
                    Step::make('Pengumpulan')
                        ->columnSpanFull()
                        ->schema([
                            Section::make([
                                Select::make('collected_by_personel_id')
                                    ->label('Personel Pengumpul')
                                    ->relationship('collectedByPersonel', 'fullname', modifyQueryUsing: fn($query) => $query->whereHas('position', fn($query) => $query->whereIn('name', [PositionEnum::Ppc->value, PositionEnum::KepalaPpc->value])))
                                    ->searchable()
                                    ->required()
                                    ->preload(),
                                TextInput::make('sample_code')
                                    ->label('Kode Sampel')
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
                                    ->columnSpanFull(),
                                TextInput::make('latitude'),
                                TextInput::make('longitude'),
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
                                TextInput::make('preservation_method')
                                    ->label('Metode Preservasi')
                                    ->maxLength(255)
                                    ->nullable(),
                                Textarea::make('collection_notes')
                                    ->label('Catatan Pengambilan')
                                    ->columnSpanFull(),
                            ])->columnSpanFull()->columns(4),
                        ]),
                    Step::make('Penerimaan')
                        ->columnSpanFull()
                        ->schema([
                            Section::make([
                                Select::make('received_by_personel_id')
                                    ->relationship('receivedByPersonel', 'fullname', modifyQueryUsing: fn($query) => $query->whereHas('position', fn($query) => $query->whereIn('name', [PositionEnum::Administrator->value])))
                                    ->label('Personel Penerima')
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
                            ])->columnSpanFull()->columns(4),
                        ]),
                ])->columnSpanFull(),
                Select::make('status')
                    ->options(SampleStatusEnum::labels())
                    ->default(SampleStatusEnum::default())
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultGroup('labJobItem.description')
            ->columns([
                TextColumn::make('labJobItem.description')
                    ->label('Deskripsi Item')
                    ->sortable(),
                TextColumn::make('sampleMatric.name')
                    ->label('Matric Sampel')
                    ->sortable(),
                TextColumn::make('collectedByPersonel.fullname')
                    ->label('Personel Pengumpul')
                    ->sortable(),
                TextColumn::make('receivedByPersonel.fullname')
                    ->label('Personel Penerima')
                    ->sortable(),
                TextColumn::make('sample_code')
                    ->label('Kode Sampel')
                    ->searchable(),
                TextColumn::make('collection_date')
                    ->label('Tanggal Pengambilan')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('collection_time')
                    ->label('Waktu Pengambilan')
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
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('status'),
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
