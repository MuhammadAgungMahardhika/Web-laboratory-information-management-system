<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\MasterGeneral\MasterGeneralCluster;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Grid;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CustomerResource\Pages\ListCustomers;
use App\Filament\Resources\CustomerResource\Pages\CreateCustomer;
use App\Filament\Resources\CustomerResource\Pages\ViewCustomer;
use App\Filament\Resources\CustomerResource\Pages\EditCustomer;
use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\City;
use App\Models\Customer;
use App\Models\Enums\CustomerStatusEnum;
use App\Models\Enums\RoleEnum;
use App\Models\Enums\UserStatusEnum;
use App\Models\Province;
use App\Traits\HasAuthorization;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CustomerResource extends Resource
{
    protected static ?string $cluster = MasterGeneralCluster::class;

    protected static ?string $model = Customer::class;
    protected static ?string $label = 'Data klien';
    protected static ?string $navigationLabel = 'Data klien';
    protected static string | \UnitEnum | null $navigationGroup = 'Client';
    protected static string | \BackedEnum | null $navigationIcon =  Heroicon::UserCircle;


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'xl' => 4,])
            ->components([
                Section::make([
                    TextInput::make('name')
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
                ])->columnSpanFull()->columns(3)->heading('Identitas')->iconColor('primary')->icon('heroicon-s-building-office'),
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
                    TextInput::make('full_address')
                        ->label('Alamat lengkap')
                        ->maxLength(255),
                    TextInput::make('postal_code')
                        ->label('Kode pos')
                        ->maxLength(255),
                ])->columnSpanFull()->columns(4)->heading('Alamat')->iconColor('primary')->icon('heroicon-s-map-pin'),

                Section::make([
                    TextInput::make('contact_person_name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('contact_person_title')
                        ->label('Jabatan')
                        ->maxLength(255),
                    TextInput::make('contact_phone_number')
                        ->label('Nomor hp')
                        ->prefix('+62 ')
                        ->required()
                        ->tel()
                        ->maxLength(255),
                    TextInput::make('contact_email')
                        ->label('Email')
                        ->email(),
                    TextInput::make('npwp')
                        ->label('Npwp')
                        ->maxLength(255),
                    Select::make('user_id')
                        ->label('Akun klien')
                        ->unique(ignoreRecord: true)
                        ->relationship(
                            'user',
                            'name',
                            modifyQueryUsing: fn(Builder $query, Get $get,  $record) => $query
                                // 1. Filter: Hanya user dengan peran 'customer'
                                ->whereHas('roles', fn($q) => $q->where('id', RoleEnum::Customer->id()))
                                // 2. Filter: Kecualikan user yang sudah menjadi personel (pekerja lab)
                                ->whereDoesntHave('personel')
                                // 3. Filter Unik: Kecualikan user yang sudah terhubung ke Customer lain
                                ->when(
                                    !$record, // Hanya terapkan filter ini saat mode CREATE
                                    fn($q) => $q->whereDoesntHave('customer')
                                )
                        )
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
                                    ->maxLength(15)
                                    ->label('Username')
                                    ->default($get('contact_person_name'))
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->autocomplete(false),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->default($get('contact_email'))
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->autocomplete(false),
                                Select::make('roles')
                                    ->label('Hak akses')
                                    ->required()
                                    ->relationship('roles', 'name', modifyQueryUsing: fn($query) => $query->where('id', RoleEnum::Customer->id()))
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(function ($record) {
                                        // Logika ini akan mengambil label dari Enum jika ada (untuk peran inti), 
                                        // atau mengambil nama dari database (untuk peran baru/fleksibel).
                                        $roleLabel = RoleEnum::tryFrom($record->name)?->label();
                                        return $roleLabel ?? $record->name;
                                    })
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
                                    ->maxLength(15)
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->autocomplete(false),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->autocomplete(false),
                                Select::make('roles')
                                    ->label('Hak akses')
                                    ->required()
                                    ->relationship('roles', 'name', modifyQueryUsing: fn($query) => $query->where('id', RoleEnum::Customer->id()))
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(function ($record) {
                                        // Logika ini akan mengambil label dari Enum jika ada (untuk peran inti), 
                                        // atau mengambil nama dari database (untuk peran baru/fleksibel).
                                        $roleLabel = RoleEnum::tryFrom($record->name)?->label();
                                        return $roleLabel ?? $record->name;
                                    })
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
                ])->columnSpanFull()->columns(4)->heading('Narahubung')->iconColor('primary')->icon('heroicon-s-user'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama klien')
                    ->searchable(),
                TextColumn::make('customerType.name')
                    ->label('Jenis klien')
                    ->searchable(),
                TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->searchable(),
                TextColumn::make('city.name')
                    ->label('Kota')
                    ->searchable(),
                TextColumn::make('full_address')
                    ->label('Alamat lengkap')
                    ->searchable(),
                TextColumn::make('postal_code')
                    ->label('Kode pos')
                    ->searchable(),
                TextColumn::make('contact_person_name')
                    ->label('Narahubung')
                    ->searchable(),
                TextColumn::make('contact_person_title')
                    ->label('Jabatan')
                    ->searchable(),
                TextColumn::make('contact_phone_number')
                    ->label('Nomor hp')
                    ->prefix('+62 ')
                    ->searchable(),
                TextColumn::make('contact_email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('npwp')
                    ->label('Npwp')
                    ->searchable(),
                TextColumn::make('registration_date')
                    ->label('Tanggal terdaftar')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status'),
                TextColumn::make('user.name')
                    ->label('Akun klien')
                    ->searchable()
                    ->sortable(),
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
                    ->schema([ // Ini adalah definisi form untuk filter saat dibuka
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
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-customer')),
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
            'index' => ListCustomers::route('/'),
            // 'create' => CreateCustomer::route('/create'),
            // 'view' => ViewCustomer::route('/{record}'),
            // 'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }
}
