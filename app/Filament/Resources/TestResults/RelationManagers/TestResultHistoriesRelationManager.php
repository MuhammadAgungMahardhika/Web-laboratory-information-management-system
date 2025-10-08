<?php

namespace App\Filament\Resources\TestResults\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestResultHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'testResultHistories';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('personel.fullname'),
                TextColumn::make('old_status'),
                TextColumn::make('new_status'),
                TextColumn::make('old_tested_value'),
                TextColumn::make('new_tested_value'),
                TextColumn::make('comment'),
                TextColumn::make('created_by'),
                TextColumn::make('updated_by'),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at'),
            ]);
    }
}
