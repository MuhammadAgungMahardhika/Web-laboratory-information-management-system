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
use App\Filament\Resources\ProvinceResource\Pages\ManageProvinces;
use App\Models\Province;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ProvinceResource extends Resource
{
    protected static ?string $cluster = MasterLocationCluster::class;

    protected static ?string $model = Province::class;
    protected static ?string $label = 'Provinsi';
    protected static ?string $navigationLabel = 'Provinsi';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::Map;
    protected static ?int $navigationSort = 1;


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),

                Repeater::make('cities')
                    ->label('Kota / Kabupaten')
                    ->addActionLabel('Tambah Kota / Kabupaten')
                    ->relationship()
                    ->hiddenLabel()
                    ->visibleOn(['view', 'edit'])
                    ->table([
                        TableColumn::make('Kota / Kabupaten'),
                    ])
                    ->components([
                        TextInput::make('name')->label('Kota / Kabupaten')
                    ])
                    ->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
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
                //
            ])
            ->recordActions([
                EditAction::make()->slideOver(),
                ViewAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-province')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProvinces::route('/'),
        ];
    }
}
