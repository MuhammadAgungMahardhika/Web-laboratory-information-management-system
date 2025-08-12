<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabJobResource\Pages;
use App\Filament\Resources\LabJobResource\RelationManagers\LabJobItemsRelationManager;
use App\Models\LabJob;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Enums\JobStatusEnum;
use Filament\Tables\Filters\SelectFilter;
use App\Services\QuotationService; // Asumsi Anda punya service untuk generate nomor
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class LabJobResource extends Resource
{
    protected static ?string $model = LabJob::class;
    protected static ?string $navigationLabel = 'Lab Job';
    protected static ?string $label = 'Lab Job';
    protected static ?string $navigationIcon = 'heroicon-s-document';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'job_number';
    protected static int $globalSearchResultsLimit = 20;

    public static function getGloballySearchableAttributes(): array
    {
        return ['job_number', 'quotation.quotation_name', 'quotation.customer.name'];
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
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pekerjaan')
                    ->schema([
                        Select::make('quotation_id')
                            ->label('Nomor Penawaran')
                            ->relationship('quotation', 'quotation_number')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('job_number')
                            ->label('Nomor Pekerjaan')
                            // Nomor pekerjaan harusnya digenerate, bukan diisi manual
                            ->default(fn(QuotationService $quotationService) => $quotationService->generateQuotationNumber())
                            ->readOnly() // <-- Jadikan read-only
                            ->maxLength(50),
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Tanggal Mulai'),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Tanggal Selesai'),
                        Select::make('status')
                            ->label('Status Pekerjaan')
                            ->options(JobStatusEnum::labels())
                            ->default(JobStatusEnum::PendingStart->value)
                            ->required(),
                    ])->columns(2),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quotation.quotation_number')
                    ->label('Nomor Penawaran')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_number')
                    ->label('Nomor Pekerjaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Pekerjaan')
                    ->badge()
                    ->sortable()
                    ->color(fn($state) => JobStatusEnum::color($state))
                    ->formatStateUsing(fn($state) => JobStatusEnum::labels()[$state]),
                Tables\Columns\TextColumn::make('created_by')
                    ->label('Dibuat Oleh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->label('Diperbarui Oleh')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Tanggal Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pekerjaan')
                    ->options(JobStatusEnum::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LabJobItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLabJobs::route('/'),
            'create' => Pages\CreateLabJob::route('/create'),
            'view' => Pages\ViewLabJob::route('/{record}'),
            'edit' => Pages\EditLabJob::route('/{record}/edit'),
        ];
    }
}
