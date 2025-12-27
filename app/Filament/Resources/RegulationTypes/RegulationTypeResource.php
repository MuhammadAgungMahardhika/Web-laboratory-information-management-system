<?php

namespace App\Filament\Resources\RegulationTypes;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Resources\RegulationTypes\Pages\CreateRegulationType;
use App\Filament\Resources\RegulationTypes\Pages\EditRegulationType;
use App\Filament\Resources\RegulationTypes\Pages\ListRegulationTypes;
use App\Filament\Resources\RegulationTypes\Pages\ViewRegulationType;
use App\Filament\Resources\RegulationTypes\Schemas\RegulationTypeForm;
use App\Filament\Resources\RegulationTypes\Schemas\RegulationTypeInfolist;
use App\Filament\Resources\RegulationTypes\Tables\RegulationTypesTable;
use App\Models\RegulationType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RegulationTypeResource extends Resource
{
    protected static ?string $cluster = MasterCluster::class;
    protected static ?string $model = RegulationType::class;
    protected static ?string $navigationLabel = 'Jenis Regulasi';
    protected static ?string $label = 'Jenis Regulasi';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RegulationTypeForm::configure($schema);
    }



    public static function table(Table $table): Table
    {
        return RegulationTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRegulationTypes::route('/'),
            // 'create' => CreateRegulationType::route('/create'),
            // 'view' => ViewRegulationType::route('/{record}'),
            // 'edit' => EditRegulationType::route('/{record}/edit'),
        ];
    }
}
