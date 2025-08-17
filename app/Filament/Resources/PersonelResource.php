<?php

namespace App\Filament\Resources;

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
use App\Filament\Resources\PersonelResource\Pages;
use App\Filament\Resources\PersonelResource\RelationManagers;
use App\Models\Enums\RoleEnum;
use App\Models\Enums\UserStatusEnum;
use App\Models\Personel;
use App\Traits\HasAuthorization;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonelResource extends Resource
{
    use HasAuthorization;
    protected static ?string $model = Personel::class;
    protected static ?string $label = 'Personel';
    protected static ?string $navigationLabel = 'Personel';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string | \UnitEnum | null $navigationGroup = "Master Pengguna";
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
                Textarea::make('certification_details')
                    ->label('Sertifikasi'),
                Select::make('user_id')
                    ->label('Akun')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->relationship('user', 'name',  modifyQueryUsing: function ($query, Get $get) {
                        $query->where(function ($query) use ($get) {
                            $query->whereDoesntHave('customer')
                                ->whereDoesntHave('personel');
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
                                ->relationship('roles', 'name', modifyQueryUsing: fn($query) => $query->whereNot('name', RoleEnum::Customer->value))
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
                                ->label('Hak akses')
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
                    })
                    ->preload(),
                Select::make('company_id')
                    ->label('Perusahaan')
                    ->required()
                    ->relationship('company', 'name')
                    ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
        return [
            //
        ];
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
