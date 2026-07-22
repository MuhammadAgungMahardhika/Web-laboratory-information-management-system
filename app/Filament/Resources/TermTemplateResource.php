<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Master\MasterCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\TermTemplateResource\Pages\ListTermTemplates;
use App\Filament\Resources\TermTemplateResource\Pages\CreateTermTemplate;
use App\Filament\Resources\TermTemplateResource\Pages\ViewTermTemplate;
use App\Filament\Resources\TermTemplateResource\Pages\EditTermTemplate;
use App\Filament\Resources\TermTemplateResource\Pages;
use App\Filament\Resources\TermTemplateResource\RelationManagers;
use App\Models\TermTemplate;
use App\Traits\HasAuthorization;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TermTemplateResource extends Resource
{
    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $model = TermTemplate::class;
    protected static ?string $navigationLabel = 'Template syarat & ketentuan';
    protected static ?string $label = 'Template syarat & ketentuan';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::DocumentCurrencyDollar;
    protected static ?int $navigationSort = 9;
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Template')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('content')
                    ->label('Isi Template')
                    ->required()
                    ->autofocus()
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Aktif ?')
                    ->required()
                    ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn($record) => $record->name)
            ->columns([
                TextColumn::make('name')
                    ->label('Nama template')
                    ->searchable(),
                TextColumn::make('content')
                    ->label('Isi template')
                    ->html()
                    ->limit(100)
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktif ?')
                    ->boolean(),
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
                //
            ])
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-term-template')),
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
            'index' => ListTermTemplates::route('/'),
            // 'create' => CreateTermTemplate::route('/create'),
            // 'view' => ViewTermTemplate::route('/{record}'),
            // 'edit' => EditTermTemplate::route('/{record}/edit'),
        ];
    }
}
