<?php

namespace App\Filament\Resources\Specializations;

use App\Filament\Clusters\MasterGeneral\MasterGeneralCluster;
use App\Filament\Resources\Specializations\Pages\ManageSpecializations;
use App\Models\Specialization;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SpecializationResource extends Resource
{
    protected static ?string $cluster = MasterGeneralCluster::class;

    protected static ?string $model = Specialization::class;
    protected static ?string $navigationLabel = 'Sertifikasi';
    protected static ?string $label = 'Sertifikasi';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckBadge;
    protected static string | \UnitEnum | null $navigationGroup = 'Internal';
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('parameters')
                    ->columnSpanFull()
                    ->relationship('parameters', 'code')
                    ->multiple()
                    ->prefixAction(
                        Action::make('selectAll')
                            ->label('Select All')
                            ->icon(Heroicon::ArrowLongLeft)
                            ->action(function (callable $set) {
                                $set('parameters', \App\Models\Parameter::pluck('id')->toArray());
                            }),
                    )
                    ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama sertifikasi')
                    ->searchable(),
                TextColumn::make('parameters.long_name_standard_notes')
                    ->label('Parameter')
                    ->listWithLineBreaks()
                    ->limitList(4)
                    ->searchable()
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
                SelectFilter::make('parameters')
                    ->label('Parameter')
                    ->searchable()
                    ->relationship('parameters', 'code')
                    ->preload()
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-specialization')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSpecializations::route('/'),
        ];
    }
}
