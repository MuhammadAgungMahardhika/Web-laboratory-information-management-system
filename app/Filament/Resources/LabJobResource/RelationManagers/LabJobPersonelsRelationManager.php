<?php

namespace App\Filament\Resources\LabJobResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Models\Enums\PositionEnum;
use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LabJobPersonelsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'labJobPersonels';
    protected static ?string $label = 'Petugas Ppc';
    protected static ?string $title = "Petugas Ppc";

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->labJobPersonels->count();
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('personel_id')
                    ->required()
                    ->searchable()
                    ->relationship('personel', 'fullname',  modifyQueryUsing: fn(Builder $query) => $query->whereHas('position', fn(Builder $query) => $query->whereIn('name', [PositionEnum::Ppc->value, PositionEnum::KepalaPpc->value])))
                    ->label('Personel')
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                TextColumn::make('personel.fullname')
                    ->label('Personel'),
                TextColumn::make('position')
                    ->label('Peran'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
