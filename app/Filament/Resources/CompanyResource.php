<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use App\Traits\HasAuthorization;
use Config;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
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
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->schema([
                Forms\Components\TextInput::make('name')
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
                Forms\Components\TextInput::make('postal_code')
                    ->label('Kode Pos')
                    ->maxLength(20),
                Forms\Components\Textarea::make('address')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('phone')
                    ->label('No Telepon')
                    ->tel()
                    ->prefix('+62')
                    ->maxLength(20),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->label('Website')
                    ->maxLength(255),
                Forms\Components\TextInput::make('npwp')
                    ->label('NPWP')
                    ->maxLength(50),

                Forms\Components\TextInput::make('default_quotation_expiry_days')
                    ->label('Default Masa berlaku penawaran (hari)')
                    ->numeric()
                    ->default(30),
                Section::make([
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
                    Forms\Components\TextInput::make('mail_mailer')
                        ->maxLength(255)
                        ->default('smtp'),
                    Forms\Components\TextInput::make('mail_host')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('mail_port')
                        ->numeric()
                        ->maxLength(255)
                        ->default(587),
                    Forms\Components\TextInput::make('mail_username')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('mail_password') // <-- Use TextInput
                        ->label('Password SMTP')
                        ->helperText('Pastikan password SMTP baru sudah ada di pengaturan Email ')
                        ->password() // <-- Ini akan menyembunyikan input password dengan titik-titik
                        ->nullable()
                        ->dehydrateStateUsing(fn($state) => filled($state) ? $state : null),
                    Forms\Components\Select::make('mail_encryption')
                        ->options([
                            'tls' => 'TLS',
                            'ssl' => 'SSL',
                            '' => 'None' // Atau 'false', tergantung kebutuhan
                        ])
                        ->default('tls')
                        ->label('Enkripsi Email'),
                    Forms\Components\TextInput::make('mail_from_address')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('mail_from_name')
                        ->default(Config('app.name'))
                        ->maxLength(255),
                ])->columns(4)->heading('Pengaturan Email'),
                Forms\Components\Toggle::make('is_main_company')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('Kota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('Kode pos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nomor hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->label('Website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npwp')
                    ->label('Npwp')
                    ->searchable(),
                ImageColumn::make('letterhead_path')
                    ->label('Korp surat'),
                Tables\Columns\TextColumn::make('default_quotation_expiry_days')
                    ->label('Default masa berlaku penawaran')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mail_mailer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_host')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_port')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_encryption')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_from_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_from_name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_main_company')
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
