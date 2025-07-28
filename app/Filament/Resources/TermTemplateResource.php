<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermTemplateResource\Pages;
use App\Filament\Resources\TermTemplateResource\RelationManagers;
use App\Models\TermTemplate;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TermTemplateResource extends Resource
{
    protected static ?string $model = TermTemplate::class;
    protected static ?string $navigationLabel = 'Template syarat & ketentuan';
    protected static ?string $label = 'Template syarat & ketentuan';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 7;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Template')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('content')
                    ->label('Isi Template')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif ?')
                    ->required()
                    ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama template')
                    ->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Isi template')
                    ->html()
                    ->limit(100) // Limit the content display to 50 characters
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif ?')
                    ->boolean(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTermTemplates::route('/'),
            'create' => Pages\CreateTermTemplate::route('/create'),
            'view' => Pages\ViewTermTemplate::route('/{record}'),
            'edit' => Pages\EditTermTemplate::route('/{record}/edit'),
        ];
    }
}
