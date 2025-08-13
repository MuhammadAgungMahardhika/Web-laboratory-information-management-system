<?php

namespace App\Filament\Resources;

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
use Filament\Forms\Form;
use Filament\Forms\Get;
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

                Forms\Components\TextInput::make('fullname')
                    ->label('Nama personel')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip')
                    ->label('Nip')
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->label('No hp')
                    ->tel()
                    ->maxLength(50),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat'),
                Forms\Components\Select::make('position')
                    ->label('Jabatan / Posisi')
                    ->relationship('position', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Textarea::make('certification_details')
                    ->label('Sertifikasi'),
                Select::make('user_id')
                    ->label('Akun')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->relationship('user', 'name',  modifyQueryUsing: function ($query, Get $get) {
                        $query->where(function ($query) use ($get) {
                            $query->whereDoesntHave('customer')
                                ->orWhereHas('personel', function ($subQuery) use ($get) {
                                    $subQuery->where('id', '=', $get('id'));
                                });
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
                                ->label('Peran')
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

                Tables\Columns\TextColumn::make('fullname')
                    ->label('Nama personel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label('Nip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Nomor hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position.name')
                    ->label('Jabatan / posisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Akun')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPersonels::route('/'),
            'create' => Pages\CreatePersonel::route('/create'),
            'view' => Pages\ViewPersonel::route('/{record}'),
            'edit' => Pages\EditPersonel::route('/{record}/edit'),
        ];
    }
}
