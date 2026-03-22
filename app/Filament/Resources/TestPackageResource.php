<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Master\MasterCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Parameter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\TestPackageResource\Pages\ListTestPackages;
use App\Filament\Resources\TestPackageResource\Pages\CreateTestPackage;
use App\Filament\Resources\TestPackageResource\Pages\ViewTestPackage;
use App\Filament\Resources\TestPackageResource\Pages\EditTestPackage;
use App\Filament\Resources\TestPackageResource\Pages;
use App\Filament\Resources\TestPackageResource\RelationManagers;
use App\Filament\Resources\TestPackageResource\RelationManagers\ParameterTestPackagesRelationManager;
use App\Models\Enums\EnvironmentTypeEnum;
use App\Models\Enums\ParameterStatusEnum;
use App\Models\TestPackage;
use App\Traits\HasAuthorization;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestPackageResource extends Resource
{
    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $model = TestPackage::class;
    protected static ?string $navigationLabel = 'Produk Uji';
    protected static ?string $label = 'Produk Uji';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::ArchiveBox;
    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 3,
            ])
            ->components([
                TextInput::make('name')
                    ->label('Nama paket pengujian')
                    ->required(),
                Select::make('sample_matric_id')
                    ->label('Matrix sampel')
                    ->required()
                    ->relationship('sampleMatric', 'name')
                    ->searchable()
                    ->createOptionForm([
                        TextInput::make('code')
                            ->label('Kode')
                            ->required()
                            ->maxLength(10),
                        Select::make('sample_type_id')
                            ->label('Jenis sampel')
                            ->required()
                            ->relationship('sampleType', 'name')
                            ->preload(),
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(100),
                        Select::make('environment_type')
                            ->label('Jenis lingkungan')
                            ->options(EnvironmentTypeEnum::labels())
                            ->required(),
                        Textarea::make('description')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])
                    ->createOptionModalHeading('Buat Matrix Sampel')
                    ->preload(),

                Select::make('regulation_id')
                    ->label('Regulasi/Standar')
                    ->searchable()
                    ->relationship('regulation', 'name')
                    ->preload(),

                Toggle::make('is_active')
                    ->label('Aktif ?')
                    ->default(true)
                    ->required(),

                Textarea::make('description')
                    ->label('Keterangan'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Harga')
                    ->prefix('Rp. '),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama paket pengujian')
                    ->searchable(),
                TextColumn::make('sampleMatric.name')
                    ->label('Matrix sampel')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('regulation.code')
                    ->label('Regulasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('idr')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('parameters.long_name_standard_notes')
                    ->label('Parameter')
                    ->listWithLineBreaks()
                    ->searchable()
                    ->badge()
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
                SelectFilter::make('sample_matric_id')
                    ->label('Matrix sampel')
                    ->relationship('sampleMatric', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('regulation_id')
                    ->label('Regulasi')
                    ->relationship('regulation', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('is_active')
                    ->label('Aktif ?')
                    ->options([
                        1 => 'Ya',
                        0 => 'Tidak',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ParameterTestPackagesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestPackages::route('/'),
            'create' => CreateTestPackage::route('/create'),
            'view' => ViewTestPackage::route('/{record}'),
            'edit' => EditTestPackage::route('/{record}/edit'),
        ];
    }
}
