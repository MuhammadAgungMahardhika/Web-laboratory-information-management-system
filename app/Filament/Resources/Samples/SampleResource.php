<?php

namespace App\Filament\Resources\Samples;

use App\Filament\Resources\Samples\Pages\CreateSample;
use App\Filament\Resources\Samples\Pages\EditSample;
use App\Filament\Resources\Samples\Pages\ListSamples;
use App\Filament\Resources\Samples\Pages\ViewSample;
use App\Filament\Resources\Samples\RelationManagers\TestResultsRelationManager;
use App\Filament\Resources\Samples\Schemas\SampleForm;
use App\Filament\Resources\Samples\Schemas\SampleInfolist;
use App\Filament\Resources\Samples\Tables\SamplesTable;
use App\Models\Sample;
use App\Models\TestResult;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SampleResource extends Resource
{
    protected static ?string $model = Sample::class;
    protected static ?string $navigationLabel = 'Sampel';
    protected static ?string $label = 'Sampel';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return SampleForm::configure($schema);
    }

    // public static function infolist(Schema $schema): Schema
    // {
    //     return SampleInfolist::configure($schema);
    // }

    public static function table(Table $table): Table
    {
        return SamplesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TestResultsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSamples::route('/'),
            'create' => CreateSample::route('/create'),
            'view' => ViewSample::route('/{record}'),
            'edit' => EditSample::route('/{record}/edit'),
        ];
    }
}
