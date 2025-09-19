<?php

namespace App\Filament\Resources\Samples\RelationManagers;

use App\Filament\Resources\TestResults\TestResultResource;
use App\Models\TestResult;
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

class TestResultsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static ?string $label = "Hasil Uji";
    protected static ?string $title = "Hasil Uji";
    protected static string $relationship = 'testResults';

    public function form(Schema $schema): Schema
    {
        return TestResultResource::form($schema);
    }

    public function table(Table $table): Table
    {
        return TestResultResource::table($table);
    }
}
