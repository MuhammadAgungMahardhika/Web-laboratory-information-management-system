<?php

namespace App\Filament\Resources\TestResults\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestResultsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sample_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('parameter_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('test_method_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('analyst_personel_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('validator_personel_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tested_value')
                    ->searchable(),
                TextColumn::make('corrected_value')
                    ->searchable(),
                TextColumn::make('unit')
                    ->searchable(),
                TextColumn::make('test_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('standard_value_ref')
                    ->searchable(),
                TextColumn::make('standard_unit_ref')
                    ->searchable(),
                TextColumn::make('standard_notes_ref')
                    ->searchable(),
                TextColumn::make('validation_status'),
                TextColumn::make('validation_date')
                    ->dateTime()
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
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
