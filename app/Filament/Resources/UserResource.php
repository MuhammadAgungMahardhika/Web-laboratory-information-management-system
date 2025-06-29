<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Enums\UserStatusEnum;
use App\Models\User;
use App\Traits\HasAuthorization;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    use HasAuthorization;
    protected static ?string $model = User::class;
    protected static ?string $label = 'Pengguna';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Master Pengguna";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama pengguna')
                    ->required()
                    ->autocomplete(false),
                TextInput::make('username')
                    ->label('Nip')
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
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->searchable()
                    // ->getOptionLabelFromRecordUsing(fn($record) => RoleStatusEnum::labels()[$record->name] ?? $record->name)
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
                Select::make('status')
                    ->required()
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
                    ->label('Peran')
                    ->getStateUsing(function ($record) {
                        return $record->roles->pluck('name')->join(', ');
                    }),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Peran')
                    ->searchable()
                    ->relationship(
                        'roles',
                        'name',
                    )
                    // ->getOptionLabelFromRecordUsing(fn($record) => RoleStatusEnum::labels()[$record->name] ?? $record->name)
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
