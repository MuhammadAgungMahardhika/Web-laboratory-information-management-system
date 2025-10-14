<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\MasterGeneral\MasterGeneralCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\PersonelResource\Pages\ListPersonels;
use App\Filament\Resources\PersonelResource\Pages\CreatePersonel;
use App\Filament\Resources\PersonelResource\Pages\ViewPersonel;
use App\Filament\Resources\PersonelResource\Pages\EditPersonel;
use App\Filament\Resources\PersonelResource\RelationManagers\PersonelParametersRelationManager;
use App\Models\Enums\RoleEnum;
use App\Models\Enums\UserStatusEnum;
use App\Models\Personel;
use App\Traits\HasAuthorization;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PersonelResource extends Resource
{
    protected static ?string $cluster = MasterGeneralCluster::class;

    protected static ?string $model = Personel::class;
    protected static ?string $label = 'Personel';
    protected static ?string $navigationLabel = 'Personel';
    protected static string | \UnitEnum | null $navigationGroup = 'Internal';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::Users;
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                TextInput::make('fullname')
                    ->label('Nama personel')
                    ->required()
                    ->maxLength(255),
                TextInput::make('nip')
                    ->label('Nip')
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('phone_number')
                    ->label('No hp')
                    ->tel()
                    ->maxLength(50),
                Textarea::make('address')
                    ->label('Alamat'),
                Select::make('position_id')
                    ->label('Jabatan / Posisi')
                    ->relationship('position', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('user_id')
                    ->label('Akun')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->relationship('user', 'name',  modifyQueryUsing: function ($query, Get $get) {
                        $query->where(function ($query) {
                            // Memastikan user belum memiliki peran 'customer'
                            $query->whereDoesntHave('roles', fn($q) => $q->where('id', RoleEnum::Customer->id()));
                        });
                    })
                    ->searchable()
                    ->createOptionForm(function (Get $get) {
                        return [
                            TextInput::make('name')
                                ->label('Nama pengguna')
                                ->default($get('fullname'))
                                ->required()
                                ->autocomplete(false),
                            TextInput::make('username')
                                ->label('Username')
                                ->maxLength(15)
                                ->default($get('fullname'))
                                ->unique(ignoreRecord: true)
                                ->required()
                                ->autocomplete(false),
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->unique(ignoreRecord: true)
                                ->required()
                                ->autocomplete(false),
                            Select::make('roles')
                                ->label('Hak akses')
                                ->required()
                                ->relationship('roles', 'name', modifyQueryUsing: fn($query) => $query->whereNot('id', RoleEnum::Customer->id()))
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
                                ->relationship('roles', 'name', modifyQueryUsing: fn($query) =>  $query->whereNot('id', RoleEnum::Customer->id()))
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
                    })
                    ->preload(),
                Select::make('company_id')
                    ->label('Perusahaan')
                    ->required()
                    ->relationship('company', 'name')
                    ->preload(),
                Repeater::make('personelSpecializations')
                    ->relationship()
                    ->label('Keahlian')
                    ->schema([
                        Select::make('specialization_id')
                            ->relationship('specialization', 'name')
                            ->label('Sertifikasi')
                            ->searchable()
                            ->required()
                            ->preload(),
                        FileUpload::make('file_path')
                            ->label('Dokumen Sertifikasi')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->previewable()
                            ->openable()
                            ->uploadProgressIndicatorPosition('left'),

                    ])
                    ->columnSpanFull()->columns(2)->grid(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('position'))
            ->columns([
                TextColumn::make('fullname')
                    ->label('Nama personel')
                    ->searchable(),
                TextColumn::make('nip')
                    ->label('Nip')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('Nomor hp')
                    ->searchable(),
                TextColumn::make('position.name')
                    ->label('Jabatan / posisi')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Akun')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPersonels::route('/'),
            'create' => CreatePersonel::route('/create'),
            'view' => ViewPersonel::route('/{record}'),
            'edit' => EditPersonel::route('/{record}/edit'),
        ];
    }
}
