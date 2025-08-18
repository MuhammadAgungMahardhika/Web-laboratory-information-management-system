<?php

namespace App\Filament\Resources\Samples;

use App\Filament\Resources\Samples\Pages\ManageSamples;
use App\Models\Sample;
use Auth;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SampleResource extends Resource
{
    protected static ?string $model = Sample::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lab_job_item_id')
                    ->relationship('labJobItem', 'description')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('sample_matric_id')
                    ->relationship('sampleMatric', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('collected_by_personel_id')
                    ->relationship('collectedByPersonel', 'fullname')
                    ->default(Auth::user()->id)
                    ->searchable()
                    ->required()
                    ->preload(),
                Select::make('received_by_personel_id')
                    ->relationship('receivedByPersonel', 'fullname')
                    ->default(Auth::user()->id)
                    ->searchable()
                    ->preload(),
                TextInput::make('sample_code')
                    ->required(),
                DatePicker::make('collection_date')
                    ->required(),
                TimePicker::make('collection_time')
                    ->required(),
                Textarea::make('collection_location_desc')
                    ->columnSpanFull(),
                TextInput::make('latitude'),
                TextInput::make('longitude'),
                TextInput::make('container_type'),
                TextInput::make('container_quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('sample_volume'),
                TextInput::make('preservation_method'),
                Textarea::make('collection_notes')
                    ->columnSpanFull(),
                DatePicker::make('received_date')
                    ->required(),
                TimePicker::make('received_time')
                    ->required(),
                Textarea::make('received_condition_notes')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'received' => 'Received',
                        'prepared' => 'Prepared',
                        'in_analysis' => 'In analysis',
                        'analysis_completed' => 'Analysis completed',
                        'invalid' => 'Invalid',
                        'archived' => 'Archived',
                    ])
                    ->default('received')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lab_job_item_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sample_matric_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('collected_by_personel_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('received_by_personel_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sample_code')
                    ->searchable(),
                TextColumn::make('collection_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('collection_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('latitude')
                    ->searchable(),
                TextColumn::make('longitude')
                    ->searchable(),
                TextColumn::make('container_type')
                    ->searchable(),
                TextColumn::make('container_quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sample_volume')
                    ->searchable(),
                TextColumn::make('preservation_method')
                    ->searchable(),
                TextColumn::make('received_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('received_time')
                    ->time()
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

    public static function getPages(): array
    {
        return [
            'index' => ManageSamples::route('/'),
        ];
    }
}
