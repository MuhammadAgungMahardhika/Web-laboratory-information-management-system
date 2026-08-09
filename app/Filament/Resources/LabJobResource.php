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
use App\Filament\Resources\LabJobResource\Pages\ListLabJobs;
use App\Filament\Resources\LabJobResource\Pages\CreateLabJob;
use App\Filament\Resources\LabJobResource\Pages\ViewLabJob;
use App\Filament\Resources\LabJobResource\Pages\EditLabJob;
use App\Filament\Resources\LabJobResource\RelationManagers\LabJobItemsRelationManager;
use App\Filament\Resources\LabJobResource\RelationManagers\LabJobPersonelsRelationManager;
use App\Filament\Resources\LabJobResource\RelationManagers\SamplesRelationManager;
use App\Models\LabJob;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Enums\JobStatusEnum;
use App\Models\Enums\QuotationStatusEnum;
use App\Services\LabJobService;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LabJobResource extends Resource
{
    protected static ?string $model = LabJob::class;
    protected static ?string $navigationLabel = 'Lab Job';
    protected static ?string $label = 'Lab Job';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::DocumentDuplicate;
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'code';
    protected static int $globalSearchResultsLimit = 20;
    protected static ?int $draftCount = null;

    protected static function draftCount(): int
    {
        return static::$draftCount ??=
            static::getEloquentQuery()
            ->where('status', JobStatusEnum::Draft->value)
            ->count();
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::draftCount();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::draftCount() > 0
            ? 'gray'
            : 'success';
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'quotation.quotation_number', 'quotation.quotation_name', 'quotation.customer.name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->code;
    }


    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Nomor job' => $record->code,
            'Nomor penawaran' => $record->quotation->quotation_number,
            'Klien' => $record->quotation->customer->name,
            'Tanggal' => Carbon::parse($record->start_date)->format('d M y')   . " - " .  Carbon::parse($record->end_date)->format('d M y')
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['quotation.customer']);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['quotation.customer', 'samples', 'labJobPersonels.personel', 'labJobItems']);
    }


    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'xl' => 4,])
            ->components([
                Section::make('Job')
                    ->heading(fn($record) => $record?->status ? 'Status -> ' .  JobStatusEnum::labels()[$record->status] : '')
                    ->iconColor(fn($record) =>  $record && $record->status ? JobStatusEnum::color($record->status) : 'primary')->icon('heroicon-s-document-duplicate')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->live()
                            ->disabledOn('edit')
                            ->visible(fn($record) => $record && $record->end_date !== null)
                            ->dehydrated()
                            ->default(now()),
                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->minDate(fn(callable $get) => $get('start_date') ?? \Carbon\Carbon::parse($get('start_date')))
                            ->afterOrEqual('start_date')
                            ->disabledOn('edit')
                            ->visible(fn($record) => $record && $record->end_date !== null)
                            ->dehydrated(),
                        Select::make('quotation_id')
                            ->label('Nomor Penawaran')
                            ->disabledOn('edit')
                            ->relationship('quotation', 'quotation_number', modifyQueryUsing: fn(Builder $query) => $query->where('status', QuotationStatusEnum::Accepted->value)->when(
                                ! $schema->getRecord(), // Hanya terapkan filter ini saat CREATE
                                fn($q) => $q->whereDoesntHave('labJob')
                            ))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Nomor penawaran yang muncul adalah penawaran yang sudah disetujui')
                            ->unique(ignoreRecord: true)
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, LabJobService $labJobService) {
                                // Jika penawaran dipilih, generate nomor job
                                if ($state) {
                                    $code = $labJobService->generateLabJobNumber();
                                    $set('code', $code);
                                } else {
                                    $set('code', null);
                                }
                            }),
                        TextInput::make('code')
                            ->label('Nomor Job')
                            ->helperText('Generate otomatis dari Nomor Penawaran')
                            ->required()
                            ->disabled() // <-- Jadikan read-only
                            ->maxLength(50),


                    ])->columnSpanFull()->columns(2),
                Repeater::make('labJobPersonels')

                    ->label('ppc')
                    ->addActionLabel('Tambah ppc')
                    ->relationship()
                    ->hiddenLabel()
                    ->visibleOn(['view', 'edit'])
                    ->table([
                        TableColumn::make('Nama Petugas'),
                        TableColumn::make('Peran'),
                    ])
                    ->components([
                        Select::make('personel_id')
                            ->required()
                            ->searchable()
                            ->relationship(
                                'personel',
                                'fullname',
                                // modifyQueryUsing: fn(Builder $query) => $query
                                //     ->whereHas(
                                //         'position',
                                //         fn(Builder $query) => $query->whereIn('name', [PositionEnum::Ppc->value, PositionEnum::KepalaPpc->value])
                                //     )->whereDoesntHave('labJobPersonels', fn(Builder $q) => $q->where('lab_job_id', $this->ownerRecord->id))
                            )
                            ->label('Nama Petugas')
                            ->preload(),
                        Select::make('position')
                            ->required()
                            ->options([
                                'ketua' => 'Ketua tim',
                                'anggota' => 'Anggota tim'
                            ])
                            ->label('Peran')
                            ->required()
                            ->default('anggota')
                            ->preload(),
                    ])->columns(1)->grid(3)->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->selectCurrentPageOnly()
            ->defaultSort('id', 'desc')
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
                TextColumn::make('code')
                    ->label('Nomor Lab Job')
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
                SelectFilter::make('status')
                    ->label('Status Lainnya')
                    ->options([
                        JobStatusEnum::Invoiced->value => 'Proses Tagihan',
                        JobStatusEnum::Paid->value => 'Lunas',
                        JobStatusEnum::OnHold->value => 'Ditunda',
                        JobStatusEnum::Cancelled->value => 'Dibatalkan',
                    ]),



            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            SamplesRelationManager::class,
            LabJobItemsRelationManager::class,
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
