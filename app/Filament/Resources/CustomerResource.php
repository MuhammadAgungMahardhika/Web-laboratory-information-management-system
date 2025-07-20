<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\City;
use App\Models\Customer;
use App\Models\Enums\CustomerStatusEnum;
use App\Models\Enums\RoleEnum;
use App\Models\Enums\UserStatusEnum;
use App\Models\Province;
use App\Traits\HasAuthorization;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    use HasAuthorization;
    protected static ?string $model = Customer::class;
    protected static ?string $label = 'Data klien';
    protected static ?string $navigationLabel = 'Data klien';
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
                Section::make([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama klien')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255),
                    Hidden::make('registration_date')
                        ->label('Tanggal didaftarkan')
                        ->default(now()),

                    Select::make('customer_type_id')
                        ->required()
                        ->label('Jenis klien')
                        ->relationship('customerType', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm(function (Get $get) {
                            return [
                                TextInput::make('name')
                                    ->label('Nama')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->autocomplete(false),
                            ];
                        })->createOptionModalHeading('Buat Jenis Klien Baru')
                        ->editOptionForm(function (Get $get) {
                            return [
                                TextInput::make('name')
                                    ->label('Nama')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->autocomplete(false),
                            ];
                        })->editOptionModalHeading('Ubah Jenis Klien'),

                    Select::make('status')
                        ->label('Status')
                        ->options(CustomerStatusEnum::labels())
                        ->default(CustomerStatusEnum::default())
                        ->required(),
                ])->columns(3)->heading('Identitas')->iconColor('primary')->icon('heroicon-s-building-office'),
                //
                Section::make([
                    Select::make('province_id')
                        ->label('Provinsi')
                        ->relationship('province', 'name')
                        ->reactive()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            $set('city_id', null);
                        })
                        ->searchable()
                        ->preload(),
                    Select::make('city_id')
                        ->label('Kota')
                        ->relationship('city', 'name', modifyQueryUsing: function (Get $get, $query) {
                            $provinceId = $get('province_id');
                            $query->where('province_id', $provinceId);
                        })
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('full_address')
                        ->label('Alamat lengkap')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('postal_code')
                        ->label('Kode pos')
                        ->maxLength(255),
                ])->columns(4)->heading('Alamat')->iconColor('primary')->icon('heroicon-s-map-pin'),

                Section::make([
                    Forms\Components\TextInput::make('contact_person_name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contact_person_title')
                        ->label('Jabatan')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contact_phone_number')
                        ->label('Nomor hp')
                        ->required()
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contact_email')
                        ->label('Email')
                        ->email(),
                    Forms\Components\TextInput::make('npwp')
                        ->label('Npwp')
                        ->maxLength(255),
                    Select::make('user_id')
                        ->label('Akun klien')
                        ->unique(ignoreRecord: true)
                        ->relationship('user', 'name',  modifyQueryUsing: function ($query, Get $get) {
                            $query->where(function ($query) use ($get) {
                                $query->whereDoesntHave('customer')
                                    ->whereDoesntHave('personel')
                                    ->orWhereHas('customer', function ($subQuery) use ($get) {
                                        $subQuery->where('id', '=', $get('id'));
                                    });
                            });
                        })
                        ->searchable()
                        ->preload()
                        ->createOptionForm(function (Get $get) {
                            return [
                                TextInput::make('name')
                                    ->label('Nama pengguna')
                                    ->default($get('contact_person_name'))
                                    ->required()
                                    ->autocomplete(false),
                                TextInput::make('username')
                                    ->label('Username')
                                    ->default($get('contact_person_name'))
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->autocomplete(false),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->default($get('contact_email'))
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->autocomplete(false),
                                Select::make('roles')
                                    ->label('Peran')
                                    ->relationship('roles', 'name', modifyQueryUsing: fn($query) => $query->where('name', RoleEnum::Customer->value))
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(fn($record) => RoleEnum::labels()[$record->name] ?? $record->name)
                                    ->preload()
                                    ->dehydrated(false),

                                TextInput::make('password')
                                    ->label('Kata sandi')
                                    ->password()
                                    ->revealable()
                                    ->required()
                                    ->default('123456')
                                    ->autocomplete(false),
                                Select::make('status')
                                    ->required()
                                    ->default(UserStatusEnum::default())
                                    ->options(UserStatusEnum::labels()),
                            ];
                        })->editOptionForm(function (Get $get) {
                            return [
                                TextInput::make('name')
                                    ->label('Nama pengguna')
                                    ->required()
                                    ->autocomplete(false),
                                TextInput::make('username')
                                    ->label('Username')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->autocomplete(false),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->autocomplete(false),
                                Select::make('roles')
                                    ->label('Peran')
                                    ->relationship('roles', 'name', modifyQueryUsing: fn($query) => $query->where('name', RoleEnum::Customer->value))
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(fn($record) => RoleEnum::labels()[$record->name] ?? $record->name)
                                    ->preload()
                                    ->dehydrated(false),

                                TextInput::make('password')
                                    ->label('Kata sandi')
                                    ->password()
                                    ->revealable()
                                    ->required()
                                    ->visible(fn(string $context) => $context === 'create')
                                    ->autocomplete(false),
                                Select::make('status')
                                    ->required()
                                    ->options(UserStatusEnum::labels()),
                            ];
                        })->helperText('Akun digunakan untuk melakukan permohonan secara online'),
                ])->columns(4)->heading('Narahubung')->iconColor('primary')->icon('heroicon-s-user'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama klien')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerType.name')
                    ->label('Jenis klien')
                    ->searchable(),
                Tables\Columns\TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('Kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_address')
                    ->label('Alamat lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('Kode pos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_person_name')
                    ->label('Narahubung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_person_title')
                    ->label('Jabatan')
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Akun klien')
                    ->searchable()
                    ->sortable(),
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
                SelectFilter::make('customer_type')
                    ->label('Jenis klien')
                    ->relationship('customerType', 'name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('location') // Beri nama filter utama ini, misalnya 'location'
                    ->label('Filter Lokasi') // Label yang akan muncul di tombol filter
                    ->indicateUsing(function (array $data): array {
                        // Ini akan menampilkan indikator (tag) di atas tabel
                        // yang menunjukkan provinsi dan kota yang sedang difilter.
                        $indicators = [];

                        if ($data['province_id'] ?? null) {
                            $province = Province::find($data['province_id']);
                            $indicators['Provinsi'] = $province?->name;
                        }

                        if ($data['city_id'] ?? null) {
                            $city = City::find($data['city_id']);
                            $indicators['Kota'] = $city?->name;
                        }

                        return $indicators;
                    })
                    ->form([ // Ini adalah definisi form untuk filter saat dibuka
                        Grid::make(2) // Kita bisa menggunakan 2 kolom untuk Provinsi dan Kota
                            ->schema([
                                Select::make('province_id')
                                    ->label('Provinsi')
                                    ->options(
                                        // Mengambil semua provinsi dari model Province
                                        Province::pluck('name', 'id')->toArray()
                                    )
                                    ->live() // Ini penting agar dropdown 'Kota' bereaksi terhadap perubahan
                                    ->searchable()
                                    ->preload(),

                                Select::make('city_id')
                                    ->label('Kota')
                                    ->options(function (Get $get) {
                                        // Ambil ID provinsi yang dipilih
                                        $provinceId = $get('province_id');

                                        // Jika provinsi belum dipilih, kembalikan array kosong
                                        if (empty($provinceId)) {
                                            return [];
                                        }

                                        // Ambil kota-kota yang berelasi dengan provinsi yang dipilih
                                        return City::where('province_id', $provinceId)
                                            ->pluck('name', 'id')
                                            ->toArray();
                                    })
                                    ->live() // Penting jika Anda punya filter lain yang bergantung pada kota (misalnya, kecamatan)
                                    ->searchable()
                                    // Hanya tampilkan filter kota jika provinsi sudah dipilih
                                    ->visible(fn(Get $get) => filled($get('province_id'))),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        // Ini adalah logika untuk menerapkan filter ke query data tabel utama Anda
                        return $query
                            ->when(
                                $data['province_id'] ?? null, // Jika ada province_id dalam data filter
                                fn(Builder $query, $provinceId): Builder => $query->where('province_id', $provinceId)
                            )
                            ->when(
                                $data['city_id'] ?? null, // Jika ada city_id dalam data filter
                                fn(Builder $query, $cityId): Builder => $query->where('city_id', $cityId)
                            );
                    })->columnSpan(2)
            ], layout: FiltersLayout::AboveContent)
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
