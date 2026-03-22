<?php

namespace App\Filament\Resources\TestPackageResource\RelationManagers;

use App\Models\Enums\ParameterStatusEnum;
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
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParameterTestPackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'parameterTestPackages';
    protected static ?string $label = 'Parameter Uji';
    protected static ?string $title = "Parameter Uji";
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('parameter_id')
                    ->relationship('parameter', 'long_name_standard_notes')
                    ->label('Kode parameter')
                    ->required()
                    ->searchable()
                    ->preload()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->columns([
                TextColumn::make('parameter.code')
                    ->label('Kode parameter')
                    ->searchable(),
                TextColumn::make('parameter.long_name_standard_notes')
                    ->label('Nama parameter uji')
                    ->searchable(),
                TextColumn::make('parameter.standard_notes')
                    ->label('Baku mutu')
                    ->searchable(),
                TextColumn::make('parameter.method')
                    ->label('Metode uji')
                    ->searchable(),
                TextColumn::make('parameter.unit')
                    ->label('Satuan')
                    ->searchable(),
                TextColumn::make('parameter.status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => ParameterStatusEnum::labels()[$state] ?? 'Unknown')
                    ->color(fn($state) => ParameterStatusEnum::color($state))
                    ->badge()
                    ->searchable(),
                TextColumn::make('parameter.default_price')
                    ->label('Harga')
                    ->money('IDR', true)
                    ->summarize(Sum::make()),

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
