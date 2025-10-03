<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Enums\RoleEnum;
use App\Models\Enums\UserStatusEnum;
use App\Models\User;
use App\Traits\HasAuthorization;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{

    protected static ?string $model = User::class;
    protected static ?string $label = 'Akun';
    protected static ?string $navigationLabel = 'Akun';
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
                TextInput::make('name')
                    ->label('Nama pengguna')
                    ->required()
                    ->autocomplete(false),
                TextInput::make('username')
                    ->label('Nip')
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
                    ->multiple()
                    ->maxItems(1)
                    ->relationship('roles', 'name')
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

                FileUpload::make('profile_photo_path')
                    ->label('Foto profil')
                    ->image()
                    ->maxSize(2048)
                    ->directory('profile-photos')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                    ->label('Profile Photo')
                    ->visibility('public'),
                Radio::make('status')
                    ->required()
                    ->inline()
                    ->options(UserStatusEnum::labels()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama pengguna')
                    ->searchable(),
                TextColumn::make('username')
                    ->label('Nip')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->iconColor('primary')
                    ->searchable(),
                TextColumn::make('roles')
                    ->label('Hak akses')
                    ->formatStateUsing(function ($record) {
                        // Ambil semua nama role dari record user
                        $roleNames = $record->roles->pluck('name');

                        // Buat array kosong untuk menyimpan label role yang ditemukan
                        $displayLabels = [];

                        // Iterasi setiap nama role
                        foreach ($roleNames as $roleName) {
                            // Coba konversi nama role (string) ke enum case
                            $enumCase = RoleEnum::tryFrom($roleName);

                            // Jika enum case ditemukan, ambil labelnya
                            if ($enumCase) {
                                $displayLabels[] = $enumCase->label();
                            } else {
                                // Jika nama role tidak ditemukan di enum, tampilkan nama aslinya atau default
                                $displayLabels[] = ucfirst($roleName); // Mengkapitalisasi nama role jika tidak ada di enum
                            }
                        }

                        // Gabungkan semua label yang ditemukan dengan koma
                        if (empty($displayLabels)) {
                            return 'Tidak ada'; // Jika tidak ada role sama sekali
                        }

                        return implode(', ', $displayLabels);
                    }),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Hak akses')
                    ->searchable()
                    ->relationship(
                        'roles',
                        'name',
                    )
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        // Logika ini akan mengambil label dari Enum jika ada (untuk peran inti), 
                        // atau mengambil nama dari database (untuk peran baru/fleksibel).
                        $roleLabel = RoleEnum::tryFrom($record->name)?->label();
                        return $roleLabel ?? $record->name;
                    })
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('resetPassword')
                    ->label('Reset Kata Sandi')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Reset Kata Sandi')
                    ->modalDescription('Apakah Anda yakin ingin mereset kata sandi pengguna ini? Kata sandi akan diubah menjadi "123456".')
                    ->modalSubmitActionLabel('Ya, Reset')
                    ->action(function (User $record) {
                        $record->password = Hash::make('123456');
                        $record->save();
                        Notification::make()
                            ->title('Kata Sandi Direset')
                            ->body('Kata sandi pengguna telah berhasil direset menjadi "123456".')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = $this->getRecord();
        if ($user) {
            $user->syncRoles($data['roles']);
        }
        unset($data['roles']);

        return $data;
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
