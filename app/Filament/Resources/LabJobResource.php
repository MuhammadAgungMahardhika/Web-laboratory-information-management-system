<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Quotation;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\LabJobResource\Pages\ListLabJobs;
use App\Filament\Resources\LabJobResource\Pages\CreateLabJob;
use App\Filament\Resources\LabJobResource\Pages\ViewLabJob;
use App\Filament\Resources\LabJobResource\Pages\EditLabJob;
use App\Filament\Resources\LabJobResource\Pages;
use App\Filament\Resources\LabJobResource\RelationManagers\LabJobItemsRelationManager;
use App\Filament\Resources\LabJobResource\RelationManagers\LabJobPersonelsRelationManager;
use App\Models\LabJob;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\QuotationStatusEnum;
use App\Services\LabJobService;
use Filament\Tables\Filters\SelectFilter;
use App\Services\QuotationService; // Asumsi Anda punya service untuk generate nomor
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class LabJobResource extends Resource
{
    protected static ?string $model = LabJob::class;
    protected static ?string $navigationLabel = 'Lab Job';
    protected static ?string $label = 'Lab Job';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-s-document';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'job_number';
    protected static int $globalSearchResultsLimit = 20;

    public static function getGloballySearchableAttributes(): array
    {
        return ['job_number', 'quotation.quotation_number', 'quotation.quotation_name', 'quotation.customer.name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->job_number;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Nomor job' => $record->job_number,
            'Nomor penawaran' => $record->quotation->quotation_number,
            'Klien' => $record->quotation->customer->name,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['quotation.customer']);
    }


    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                Section::make('Job')
                    ->heading(fn($record) => $record?->status ? 'Status -> ' .  JobStatusEnum::labels()[$record->status] : '')
                    ->iconColor(fn($record) =>  $record && $record->status ? JobStatusEnum::color($record->status) : 'primary')->icon('heroicon-s-document-duplicate')
                    ->inlineLabel()
                    ->schema([
                        Select::make('quotation_id')
                            ->label('Nomor Penawaran')
                            ->relationship('quotation', 'quotation_number', modifyQueryUsing: fn(Builder $query) => $query->where('status', QuotationStatusEnum::Accepted->value)->when(
                                ! $schema->getRecord(), // Hanya terapkan filter ini saat CREATE
                                fn($q) => $q->whereDoesntHave('labJob')
                            ))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, LabJobService $labJobService) {
                                // Jika penawaran dipilih, generate nomor job
                                if ($state) {
                                    $quotation = Quotation::find($state);
                                    $job_number = $labJobService->generateLabJobNumber($quotation);
                                    $set('job_number', $job_number);
                                } else {
                                    $set('job_number', null);
                                }
                            }),
                        TextInput::make('job_number')
                            ->label('Nomor Job')
                            ->required()
                            ->readOnly() // <-- Jadikan read-only
                            ->maxLength(50),
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->default(now()),
                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai'),

                    ])->columnSpanFull()->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->color(fn($state) => JobStatusEnum::color($state))
                    ->formatStateUsing(fn($state) => JobStatusEnum::labels()[$state]),
                TextColumn::make('quotation.quotation_number')
                    ->label('Nomor Penawaran')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('job_number')
                    ->label('Nomor Pekerjaan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('created_by')
                    ->searchable(),
                TextColumn::make('updated_by')
                    ->searchable()
                    ->toggleable(),
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
                SelectFilter::make('quotation.quotation_number')
                    ->label('Nomor Penawaran')
                    ->relationship('quotation', 'quotation_number')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('customer')
                    ->label('Klien')
                    ->relationship('quotation.customer', 'name')
                    ->searchable()
                    ->preload(),
                // SelectFilter::make('status')
                //     ->label('Status Pekerjaan')
                //     ->options(JobStatusEnum::labels())
                //     ->default(JobStatusEnum::PendingStart->value)
                //     ->searchable()
                //     ->preload(),
            ], layout: FiltersLayout::AboveContent)
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

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('update-lab-job') && $record->status === JobStatusEnum::PendingStart->value;
    }
    public static function getRelations(): array
    {
        return [
            RelationGroup::make('items', [
                LabJobItemsRelationManager::class,
                LabJobPersonelsRelationManager::class,
            ]),

            // Asumsi Anda punya relation manager untuk personel
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLabJobs::route('/'),
            'create' => CreateLabJob::route('/create'),
            'view' => ViewLabJob::route('/{record}'),
            'edit' => EditLabJob::route('/{record}/edit'),
        ];
    }
}
