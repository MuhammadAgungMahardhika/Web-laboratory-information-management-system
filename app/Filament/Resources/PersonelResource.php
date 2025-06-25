<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonelResource\Pages;
use App\Filament\Resources\PersonelResource\RelationManagers;
use App\Models\Personel;
use App\Traits\HasAuthorization;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
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
    protected static ?string $navigationGroup = "Master";
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
                    ->required()
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('fullname')
                    ->label('Nama personel')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip')
                    ->label('Nip')
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->label('No hp')
                    ->tel()
                    ->maxLength(50),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('position')
                    ->label('Jabatan / Posisi'),
                Forms\Components\Textarea::make('certification_details')
                    ->label('Sertifikasi')
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->searchable()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->relationship(
                        'user',
                        'name'
                    )
                    ->label('Akun')
                    ->preload(),
                Forms\Components\TextInput::make('created_by')
                    ->maxLength(255),
                Forms\Components\TextInput::make('updated_by')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fullname')
                    ->label('Nama personel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label('Nip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Nomor hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan / posisi')
                    ->searchable(),
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
