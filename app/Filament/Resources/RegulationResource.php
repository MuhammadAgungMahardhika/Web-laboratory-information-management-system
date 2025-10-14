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
use App\Models\Regulation;
use App\Traits\HasAuthorization;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
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
                TextInput::make('name')
                    ->required()
                    ->label('Nama regulasi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama regulasi')
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
            'index' => ManageRegulations::route('/'),
        ];
    }
}
