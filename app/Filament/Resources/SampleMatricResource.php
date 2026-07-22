<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Master\MasterCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\SampleMatricResource\Pages\ManageSampleMatrics;
use App\Models\Enums\EnvironmentTypeEnum;
use App\Models\SampleMatric;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SampleMatricResource extends Resource
{
    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $model = SampleMatric::class;
    protected static ?string $navigationLabel = 'Matrix Sampel';
    protected static ?string $label = 'Matrix Sampel';
    protected static string | \UnitEnum | null $navigationGroup = 'Sampel';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::NumberedList;
    protected static ?int $navigationSort = 2;
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                TextInput::make('code')
                    ->label('Kode')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                Select::make('sample_type_id')
                    ->label('Jenis sampel')
                    ->required()
                    ->searchable()
                    ->relationship('sampleType', 'name')
                    ->preload(),
                TextInput::make('name')
                    ->label('Nama')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(100),
                Select::make('environment_type')
                    ->label('Jenis lingkungan')
                    ->searchable()
                    ->options(EnvironmentTypeEnum::labels())
                    ->getOptionLabelFromRecordUsing(fn($record) => EnvironmentTypeEnum::labels()[$record->name] ?? $record->name)
                    ->required(),
                Textarea::make('description')
                    ->label('Keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->defaultSort('code', 'asc')
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('sampleType.name')
                    ->label('Jenis sampel')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama matrix')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('environment_type')
                    ->formatStateUsing(fn($state) => EnvironmentTypeEnum::labels()[$state])
                    ->label('Jenis lingkungan')
                    ->sortable(),
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
                SelectFilter::make('environment_type')
                    ->label('Jenis lingkungan')
                    ->options(EnvironmentTypeEnum::labels()),
                SelectFilter::make('sample_type_id')
                    ->label('Jenis sampel')
                    ->searchable()
                    ->relationship('sampleType', 'name')
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
                DeleteAction::make()->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-sample-matric')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSampleMatrics::route('/'),
        ];
    }
}
