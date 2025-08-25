<?php

namespace App\Filament\Resources\TestResults\Tables;

use App\Models\Enums\RoleEnum;
use Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use View;

class TestResultsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (Auth::user()->hasRole(RoleEnum::Analyst->value)) {
                }
                return $query;
            })
            ->striped()
            ->columns([
                TextColumn::make('sample.sample_code'),
                TextColumn::make('parameter.name'),
                TextColumn::make('testMethod.name'),
                TextColumn::make('analyst_personel.fullname'),
                TextColumn::make('validator_personel.fullname'),

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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
