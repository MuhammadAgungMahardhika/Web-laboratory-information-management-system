<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\MasterGeneral\MasterGeneralCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CustomerTypeResource\Pages\ManageCustomerTypes;
use App\Models\CustomerType;
use App\Traits\HasAuthorization;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustomerTypeResource extends Resource
{
    protected static ?string $cluster = MasterGeneralCluster::class;

    protected static ?string $model = CustomerType::class;
    protected static ?string $navigationLabel = 'Jenis Pelanggan';
    protected static ?string $label = 'Jenis Pelanggan';
    protected static string | \UnitEnum | null $navigationGroup = 'Client';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::ListBullet;


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
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
            'index' => ManageCustomerTypes::route('/'),
        ];
    }
}
