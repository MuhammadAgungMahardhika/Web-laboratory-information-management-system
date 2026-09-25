<?php

namespace App\Filament\Resources\TestResults;

use App\Filament\Resources\TestResults\Pages\ListTestResults;
use App\Filament\Resources\TestResults\RelationManagers\TestResultHistoriesRelationManager;
use App\Filament\Resources\TestResults\Schemas\TestResultForm;
use App\Filament\Resources\TestResults\Tables\TestResultsTable;
use App\Models\Enums\TestResultApprovalStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Models\User;
use App\Services\TestResultApprovalService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Override;
use Filament\Actions\Action;

class TestResultResource extends Resource
{
    protected static ?string $model = TestResult::class;
    protected static ?string $navigationLabel = 'Pengujian';
    protected static ?string $label = 'Pengujian';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Beaker;
    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'sample.code';
    protected static ?int $pendingCount = null;

    /**
     * User dianggap "approver" kalau dia punya salah satu permission
     * approve-test-result-level-*. Approver tidak dibatasi specialization.
     */

    #[Override]
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Nomor Sampel' => $record->sample->code,
            'Parameter' => $record->parameter->long_name,
            'Status' => TestResultStatusEnum::labels()[$record->status]
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['sample.labJobItem', 'parameter', 'testResultHistories.personel',    'testResultApprovals' => fn($query) => $query
            ->where('status', TestResultApprovalStatusEnum::Pending->value)
            ->orderBy('approval_level')
            ->orderByDesc('id'),]);
    }



    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Action::make('edit')
                ->label('Edit')
                ->url(static::getUrl('index', [
                    'tableAction' => 'edit',
                    'tableActionRecord' => $record->getKey(),
                ])),
            Action::make('view')
                ->label('View')
                ->url(static::getUrl('index', [
                    'tableAction' => 'view',
                    'tableActionRecord' => $record->getKey(),
                ])),
        ];
    }
    protected static function isApprover(User $user): bool
    {
        if (!$user)
        {
            return false;
        }

        foreach (TestResultApprovalService::LEVEL_PERMISSIONS as $permission)
        {
            if ($user->can($permission))
            {
                return true;
            }
        }

        return false;
    }

    protected static function pendingCount(): int
    {
        if (static::$pendingCount !== null)
        {
            return static::$pendingCount;
        }

        $user = Auth::user();

        if (static::isApprover($user))
        {
            // Badge buat approver = jumlah record yang punya approval pending
            // di level yang dia punya izinnya.
            $myLevels = collect(TestResultApprovalService::LEVEL_PERMISSIONS)
                ->filter(fn($permission) => $user->can($permission))
                ->keys();

            return static::$pendingCount = static::getEloquentQuery()
                ->whereHas('testResultApprovals', function ($q) use ($myLevels)
                {
                    $q->where('status', TestResultApprovalStatusEnum::Pending->value)
                        ->whereIn('approval_level', $myLevels);
                })
                ->count();
        }

        // Badge buat analis = jumlah record yang masih Raw (belum di-submit)
        return static::$pendingCount = static::getEloquentQuery()
            ->where('status', TestResultStatusEnum::Raw->value)
            ->count();
    }

    public static function form(Schema $schema): Schema
    {
        return TestResultForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['validatorPersonel', 'analystPersonel', 'testMethod', 'sample.labJobItem.labJob', 'parameter', 'testResultHistories.personel',    'testResultApprovals' => fn($query) => $query
            ->orderBy('approval_level')
            ->orderByDesc('id'),]);
        $user = Auth::user();

        // Approver: lihat semua record (tidak dibatasi specialization),
        // karena hak lihat/approve ditentukan permission, bukan keahlian teknis.
        if (static::isApprover($user))
        {
            return $query;
        }

        // Analis: tetap dibatasi ke specialization miliknya.
        return $query->visibleForUser($user);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::pendingCount();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::pendingCount() > 0  ? 'gray'
            : 'success';
    }

    public static function table(Table $table): Table
    {
        return TestResultsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestResults::route('/'),
        ];
    }
}
