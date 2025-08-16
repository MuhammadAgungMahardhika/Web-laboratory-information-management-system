<?php

namespace App\Filament\Resources\LabJobResource\RelationManagers;

use App\Models\Enums\PositionEnum;
use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
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
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('personel_id')
                    ->required()
                    ->searchable()
                    ->relationship('personel', 'fullname',  modifyQueryUsing: fn(Builder $query) => $query->whereHas('position', fn(Builder $query) => $query->whereIn('name', [PositionEnum::Ppc->value, PositionEnum::KepalaPpc->value])))
                    ->label('Personel')
                    ->preload(),
                Forms\Components\Select::make('position')
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
                Tables\Columns\TextColumn::make('personel.fullname')
                    ->label('Personel'),
                Tables\Columns\TextColumn::make('position')
                    ->label('Peran'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
