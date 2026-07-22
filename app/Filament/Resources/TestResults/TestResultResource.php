<?php

namespace App\Filament\Resources\TestResults;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Resources\TestResults\Pages\CreateTestResult;
use App\Filament\Resources\TestResults\Pages\EditTestResult;
use App\Filament\Resources\TestResults\Pages\ListTestResults;
use App\Filament\Resources\TestResults\Pages\ViewTestResult;
use App\Filament\Resources\TestResults\RelationManagers\TestResultHistoriesRelationManager;
use App\Filament\Resources\TestResults\Schemas\TestResultForm;
use App\Filament\Resources\TestResults\Schemas\TestResultInfolist;
use App\Filament\Resources\TestResults\Tables\TestResultsTable;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TestResultResource extends Resource
{

    protected static ?string $model = TestResult::class;
    protected static ?string $navigationLabel = 'Hasil Pengujian';
    protected static ?string $label = 'Hasil Pengujian';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Beaker;
    protected static ?int $navigationSort = 4;

    protected static ?int $pendingCount = null;

    protected static function pendingCount(): int
    {
        return static::$pendingCount ??=
            static::getEloquentQuery()
            ->where('status', TestResultStatusEnum::Raw)
            ->count();
    }
    public static function form(Schema $schema): Schema
    {
        return TestResultForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['testMethod'])
            ->visibleForUser(Auth::user());
    }
    public static function getNavigationBadge(): ?string
    {
        return (string) static::pendingCount();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::pendingCount() > 0
            ? 'warning'
            : 'success';
    }

    public static function table(Table $table): Table
    {
        return TestResultsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TestResultHistoriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestResults::route('/'),
            // 'create' => CreateTestResult::route('/create'),
            // 'view' => ViewTestResult::route('/{record}'),
            // 'edit' => EditTestResult::route('/{record}/edit'),
        ];
    }
}
