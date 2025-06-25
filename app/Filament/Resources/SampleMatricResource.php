<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SampleMatricResource\Pages;
use App\Filament\Resources\SampleMatricResource\RelationManagers;
use App\Models\Enums\EnvironmentTypeEnum;
use App\Models\SampleMatric;
use App\Traits\HasAuthorization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SampleMatricResource extends Resource
{
    use HasAuthorization;
    protected static ?string $model = SampleMatric::class;
    protected static ?string $navigationLabel = 'Matrix Sampel';
    protected static ?string $label = 'Matrix Sampel';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode')
                    ->required()
                    ->maxLength(10),
                Forms\Components\Select::make('sample_type_id')
                    ->label('Jenis sampel')
                    ->required()
                    ->relationship('sampleType', 'name')
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Select::make('environment_type')
                    ->label('Jenis lingkungan')
                    ->options(EnvironmentTypeEnum::labels())
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Keterangan')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sampleType.name')
                    ->label('Jenis sampel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama matrix')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('environment_type')->label('Jenis lingkungan')->sortable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSampleMatrics::route('/'),
        ];
    }
}
