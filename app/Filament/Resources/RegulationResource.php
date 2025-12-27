<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Master\MasterCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\RegulationResource\Pages\ManageRegulations;
use App\Filament\Resources\RegulationResource\Pages;
use App\Filament\Resources\RegulationResource\RelationManagers;
use App\Models\Enums\RegulationTypeEnum;
use App\Models\Regulation;
use App\Models\RegulationType;
use App\Traits\HasAuthorization;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegulationResource extends Resource
{
    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $model = Regulation::class;
    protected static ?string $navigationLabel = 'Regulasi';
    protected static ?string $label = 'Regulasi';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::DocumentChartBar;
    protected static ?int $navigationSort = 3;
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('regulation_type_id')
                    ->label('Jenis Regulasi')
                    ->relationship('regulationType', 'name')
                    ->afterStateUpdated(function (Set $set, $state) {
                        if ($state) {
                            $regulationType = RegulationType::find($state);
                            if ($regulationType) {
                                // Set prefix dari nama regulation type
                                $prefix = $regulationType->name;
                                $set('name', $prefix . ' ');
                            }
                        }
                    })
                    ->required()
                    ->live()
                    ->preload(),
                TextInput::make('name')
                    ->required()
                    ->hint(function (Get $get) {
                        $regulationTypeId = $get('regulation_type_id');
                        if ($regulationTypeId) {
                            $regulationType = RegulationType::find($regulationTypeId);
                            return $regulationType ? "Awalan: {$regulationType->name}" : null;
                        }
                        return null;
                    })
                    ->label('Nama regulasi')
                    ->maxLength(255),

                Textarea::make('long_name')
                    ->required()
                    ->label('Nama lengkap regulasi')
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('regulationType.name')
                    ->label('Jenis regulasi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Regulasi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('long_name')
                    ->label('Nama lengkap regulasi')
                    ->searchable(),

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
                SelectFilter::make('regulationType')
                    ->label('Jenis Regulasi')
                    ->multiple()
                    ->relationship('regulationType', 'name')
                    ->searchable()
                    ->preload()
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
                DeleteAction::make()->slideOver(),
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
            'index' => ManageRegulations::route('/'),
        ];
    }
}
