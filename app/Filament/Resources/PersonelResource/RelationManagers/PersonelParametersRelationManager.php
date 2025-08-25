<?php

namespace App\Filament\Resources\PersonelResource\RelationManagers;

use App\Models\Enums\ParameterStatusEnum;
use App\Models\Enums\PositionEnum;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PersonelParametersRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'personelParameters';
    protected static ?string $label = 'Keahlian';
    protected static ?string $title = "Keahlian";

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('parameter_id')
                    ->relationship('parameter', 'name', modifyQueryUsing: fn($query) => $query->whereDoesntHave('personelParameters', fn($q) => $q->where('personel_id', $this->ownerRecord->id)))
                    ->searchable()
                    ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('parameter.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parameter.status')
                    ->label('Status')
                    ->searchable()
                    ->formatStateUsing(fn($state) => ParameterStatusEnum::labels()[$state])
                    ->badge()
                    ->color(fn($state) => ParameterStatusEnum::color($state))
                    ->sortable(),
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
