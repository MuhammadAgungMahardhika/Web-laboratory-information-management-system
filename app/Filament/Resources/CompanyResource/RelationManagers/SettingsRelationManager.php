<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                Toggle::make('is_active')
                    ->label('Aktif ?'),
                TextInput::make('default_quotation_expiry_days')
                    ->label('Default Masa berlaku penawaran (hari)')
                    ->numeric()
                    ->default(30),

                Select::make('term_template_id')
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
                    TextInput::make('mail_mailer')
                        ->maxLength(255)
                        ->default('smtp'),
                    TextInput::make('mail_host')
                        ->maxLength(255),
                    TextInput::make('mail_port')
                        ->numeric()
                        ->maxLength(255)
                        ->default(587),
                    TextInput::make('mail_username')
                        ->maxLength(255),
                    TextInput::make('mail_password') // <-- Use TextInput
                        ->label('Password SMTP')
                        ->helperText('Pastikan password SMTP baru sudah ada di pengaturan Email ')
                        ->password() // <-- Ini akan menyembunyikan input password dengan titik-titik
                        ->nullable()
                        ->dehydrateStateUsing(fn($state) => filled($state) ? $state : null),
                    Select::make('mail_encryption')
                        ->options([
                            'tls' => 'TLS',
                            'ssl' => 'SSL',
                            '' => 'None' // Atau 'false', tergantung kebutuhan
                        ])
                        ->default('tls')
                        ->label('Enkripsi Email'),
                    TextInput::make('mail_from_address')
                        ->maxLength(255),
                    TextInput::make('mail_from_name')
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
                TextColumn::make('default_quotation_expiry_days')
                    ->label('Default masa berlaku penawaran')
                    ->numeric()
                    ->alignEnd()
                    ->sortable(),
                TextColumn::make('termTemplate.name')
                    ->label('Template syarat & ketentuan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mail_mailer')
                    ->searchable(),
                TextColumn::make('mail_host')
                    ->searchable(),
                TextColumn::make('mail_port')
                    ->alignEnd()
                    ->searchable(),
                TextColumn::make('mail_username')
                    ->searchable(),
                TextColumn::make('mail_encryption')
                    ->searchable(),
                TextColumn::make('mail_from_address')
                    ->searchable(),
                TextColumn::make('mail_from_name')
                    ->searchable(),
                TextColumn::make('is_active')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
