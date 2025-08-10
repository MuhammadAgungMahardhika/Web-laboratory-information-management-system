<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'settings';

    public function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->schema([
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif ?'),
                Forms\Components\TextInput::make('default_quotation_expiry_days')
                    ->label('Default Masa berlaku penawaran (hari)')
                    ->numeric()
                    ->default(30),

                Forms\Components\Select::make('term_template_id')
                    ->label('Template syarat & ketentuan')
                    ->relationship('termTemplate', 'name')
                    ->searchable()
                    ->preload(),
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                ImageColumn::make('letterhead_path')
                    ->label('Korp surat'),
                Tables\Columns\TextColumn::make('default_quotation_expiry_days')
                    ->label('Default masa berlaku penawaran')
                    ->numeric()
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextColumn::make('termTemplate.name')
                    ->label('Template syarat & ketentuan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mail_mailer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_host')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_port')
                    ->alignEnd()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_encryption')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_from_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_from_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_active')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
