<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\MasterLocation\MasterLocationCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CityResource\Pages\ManageCities;
use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use App\Traits\HasAuthorization;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CityResource extends Resource
{
    protected static ?string $cluster = MasterLocationCluster::class;

    protected static ?string $model = City::class;
    protected static ?string $label = 'Kota / Kabupaten';
    protected static ?string $navigationLabel = 'Kota / Kabupaten';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::MapPin;
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('province_id')
                    ->label('Provinsi')
                    ->relationship('province', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('name')
                    ->label('Nama')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('province.name')
                    ->label('Provinsi')
                    ->collapsible(),
            ])
            ->defaultGroup('province.name')
            ->striped()
            ->columns([
                TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama')
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
                SelectFilter::make('province_id')
                    ->label('Provinsi')
                    ->relationship('province', 'name')
                    ->preload()
                    ->searchable(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-city')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCities::route('/'),
        ];
    }
}
