<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Master\MasterCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\TestMethodResource\Pages\ManageTestMethods;
use App\Models\TestMethod;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TestMethodResource extends Resource
{
    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $model = TestMethod::class;
    protected static ?string $navigationLabel = 'Metode Uji';
    protected static ?string $label = 'Metode Uji';
    protected static string | \UnitEnum | null $navigationGroup = 'Parameter';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::Scale;
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'xl' => 4,])
            ->components([
                TextInput::make('name')
                    ->label('Nama metode uji')
                    ->required(),
                Textarea::make('description')
                    ->label('Keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama metode uji')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Keterangan'),
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
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-test-method')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTestMethods::route('/'),
        ];
    }
}
