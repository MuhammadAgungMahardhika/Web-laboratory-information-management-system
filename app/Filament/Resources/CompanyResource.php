<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CompanyResource\Pages\ListCompanies;
use App\Filament\Resources\CompanyResource\Pages\CreateCompany;
use App\Filament\Resources\CompanyResource\Pages\ViewCompany;
use App\Filament\Resources\CompanyResource\Pages\EditCompany;
use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Filament\Resources\CompanyResource\RelationManagers\SettingsRelationManager;
use App\Models\Company;
use App\Traits\HasAuthorization;
use Config;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    use HasAuthorization;
    protected static ?string $model = Company::class;
    protected static ?string $navigationLabel = 'Perusahaan';
    protected static ?string $label = 'Perusahaan';
    protected static string | \UnitEnum | null $navigationGroup = 'Master';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('province_id')
                    ->label('Provinsi')
                    ->relationship('province', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('city_id')
                    ->label('Kota')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('postal_code')
                    ->label('Kode Pos')
                    ->maxLength(20),
                Textarea::make('address')
                    ->columnSpanFull(),

                TextInput::make('phone')
                    ->label('No Telepon')
                    ->tel()
                    ->prefix('+62')
                    ->maxLength(20),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('website')
                    ->label('Website')
                    ->maxLength(255),
                TextInput::make('npwp')
                    ->label('NPWP')
                    ->maxLength(50),



                Toggle::make('is_main_company')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama perusahaan')
                    ->searchable(),
                TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('city.name')
                    ->label('Kota')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('postal_code')
                    ->label('Kode pos')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Nomor hp')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('website')
                    ->label('Website')
                    ->searchable(),
                TextColumn::make('npwp')
                    ->label('Npwp')
                    ->searchable(),

                IconColumn::make('is_main_company')
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SettingsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanies::route('/'),
            'create' => CreateCompany::route('/create'),
            'view' => ViewCompany::route('/{record}'),
            'edit' => EditCompany::route('/{record}/edit'),
        ];
    }
}
