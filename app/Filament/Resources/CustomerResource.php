<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\Enums\CustomerStatusEnum;
use App\Traits\HasAuthorization;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    use HasAuthorization;
    protected static ?string $model = Customer::class;
    protected static ?string $label = 'Data pelanggan';
    protected static ?string $navigationLabel = 'Data pelanggan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Master Pengguna";


    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->schema([
                Select::make('user_id')
                    ->label('Akun pelanggan')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
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
                Forms\Components\TextInput::make('code')
                    ->label('Kode pelanggan / perusahaan')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('name')
                    ->label('Nama perusahaan / pelanggan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->label('Jenis pelanggan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('full_address')
                    ->label('Alamat lengkap')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('Kota')
                    ->maxLength(255),
                Forms\Components\TextInput::make('province')
                    ->label('Provinsi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('postal_code')
                    ->label('Kode pos')
                    ->maxLength(255),

                // 
                Forms\Components\TextInput::make('contact_person_name')
                    ->label('Narahubung')
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_person_title')
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_phone_number')
                    ->label('Nomor hp')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_email')
                    ->label('Email')
                    ->email(),
                Forms\Components\TextInput::make('npwp')
                    ->label('Npwp')
                    ->maxLength(255),
                Hidden::make('registration_date')
                    ->label('Tanggal didaftarkan')
                    ->default(now()),
                Select::make('status')
                    ->label('Status')
                    ->options(CustomerStatusEnum::labels())
                    ->default(CustomerStatusEnum::default())
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Akun pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode pelanggan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama perusahaan / pelanggan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis pelanggan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_address')
                    ->label('Alamat lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('province')
                    ->label('Provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('Kode pos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_person_name')
                    ->label('Naarahubung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_person_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_phone_number')
                    ->label('Nomor hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npwp')
                    ->label('Npwp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_date')
                    ->label('Tanggal terdaftar')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status'),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
