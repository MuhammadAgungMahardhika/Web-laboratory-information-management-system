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
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section as ComponentsSection;

use Filament\Tables\Table;

class CompanyResource extends Resource
{
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

                Repeater::make('settings')
                    ->relationship()
                    ->label('Pengaturan')
                    ->maxItems(1)
                    ->columns(2)
                    ->schema([
                        ComponentsSection::make([
                            Toggle::make('is_active')
                                ->label('Aktif ?'),
                            TextInput::make('default_quotation_expiry_days')
                                ->label('Default Masa berlaku penawaran (hari)')
                                ->numeric()
                                ->default(30),

                            Select::make('term_template_id')
                                ->label('Template syarat & ketentuan')
                                ->relationship('termTemplate', 'name')
                                ->searchable()
                                ->preload(),
                        ])->columns(4)->heading('Setting')->columnSpanFull(),
                        ComponentsSection::make([
                            FileUpload::make('letterhead_path')
                                ->label('Kop Surat')
                                ->image()
                                ->disk('public')
                                ->previewable()
                                ->directory('company_letterheads')
                                ->visibility('public')
                                ->maxSize(1024)
                                ->acceptedFileTypes(['image/jpeg', 'image/png'])
                                ->columnSpanFull(),
                            TextInput::make('mail_mailer')
                                ->maxLength(255)
                                ->default('smtp'),
                            TextInput::make('mail_host')
                                ->maxLength(255),
                            TextInput::make('mail_port')
                                ->numeric()
                                ->maxLength(255)
                                ->default(587),
                            TextInput::make('mail_username')
                                ->maxLength(255),
                            TextInput::make('mail_password') // <-- Use TextInput
                                ->label('Password SMTP')
                                ->helperText('Pastikan password SMTP baru sudah ada di pengaturan Email ')
                                ->password() // <-- Ini akan menyembunyikan input password dengan titik-titik
                                ->nullable()
                                ->dehydrateStateUsing(fn($state) => filled($state) ? $state : null),
                            Select::make('mail_encryption')
                                ->options([
                                    'tls' => 'TLS',
                                    'ssl' => 'SSL',
                                    '' => 'None' // Atau 'false', tergantung kebutuhan
                                ])
                                ->default('tls')
                                ->label('Enkripsi Email'),
                            TextInput::make('mail_from_address')
                                ->maxLength(255),
                            TextInput::make('mail_from_name')
                                ->default(Config('app.name'))
                                ->maxLength(255),
                        ])->columns(4)->heading('Pengaturan Email')->columnSpanFull(),
                    ])->columnSpanFull()
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
            // SettingsRelationManager::class
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
