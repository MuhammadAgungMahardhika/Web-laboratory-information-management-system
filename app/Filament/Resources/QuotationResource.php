<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Filament\Resources\QuotationResource\RelationManagers\QuotationItemRelationManager;
use App\Models\Enums\CustomerStatusEnum;
use App\Models\Enums\RoleEnum;
use App\Models\Quotation;
use App\Services\QuotationService;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationLabel = 'Penawaran';
    protected static ?string $label = 'Penawaran';

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function form(Form $form): Form
    {
        $quoatationService = app(QuotationService::class);

        return $form
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->schema([
                Section::make([
                    Forms\Components\DatePicker::make('quotation_date')
                        ->label('Tanggal penawaran')
                        ->default(now())
                        ->required(),
                    Forms\Components\TextInput::make('quotation_number')
                        ->label('Nomor penawaran')
                        ->required()
                        ->default($quoatationService->generateQuotationNumber())
                        ->maxLength(50),
                    Select::make('request_id')
                        ->label('Nomor permohonan')
                        ->relationship('request', 'request_number')
                        ->helperText('Kosongkan jika bukan dari permohonan'),

                    Forms\Components\TextInput::make('quotation_name')
                        ->label('Judul penawaran')
                        ->required(),

                    Select::make('customer_id')
                        ->label('Klien')
                        ->required()
                        ->relationship('customer', 'name')
                        ->preload()
                        ->searchable()
                        ->createOptionForm(function (Get $get) {
                            return [
                                Section::make([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nama klien')
                                        ->unique(ignoreRecord: true)
                                        ->required()
                                        ->maxLength(255),
                                    Select::make('customer_type_id')
                                        ->required()
                                        ->label('Jenis klien')
                                        ->relationship('customerType', 'name')
                                        ->searchable()
                                        ->preload(),

                                    Hidden::make('registration_date')
                                        ->default(now()),

                                    Hidden::make('status')
                                        ->default(CustomerStatusEnum::default()),
                                ])->columns(2)->collapsible()->heading('Identitas')->iconColor('primary')->icon('heroicon-s-building-office'),
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
                                ])->columns(4)->collapsible()->heading('Alamat')->iconColor('primary')->icon('heroicon-s-map-pin'),

                                Section::make([
                                    Forms\Components\TextInput::make('contact_person_name')
                                        ->label('Nama')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('contact_phone_number')
                                        ->label('Nomor hp')
                                        ->required()
                                        ->tel()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('contact_person_title')
                                        ->label('Jabatan')
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('contact_email')
                                        ->label('Email')
                                        ->email(),
                                    Forms\Components\TextInput::make('npwp')
                                        ->label('Npwp')
                                        ->maxLength(255),
                                    Select::make('user_id')
                                        ->label('Akun pelanggan')
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
                                        ->preload(),
                                ])->columns(4)->collapsible()->heading('Narahubung')->iconColor('primary')->icon('heroicon-s-user'),
                            ];
                        })->createOptionModalHeading('Buat Klien Baru'),
                    Select::make('personel_id')
                        ->label('Petugas')
                        ->required()
                        ->relationship('personel', 'fullname', modifyQueryUsing: fn($query) =>
                        $query->whereHas(
                            'user',
                            fn($qUser) =>
                            $qUser->whereHas(
                                'roles',
                                fn($qRole) =>
                                $qRole->where('name', RoleEnum::Admin->value)
                                    ->orWhere('name', RoleEnum::SuperAdmin->value)
                            )
                        ))
                        ->default(Auth::user()->id)
                        ->searchable()
                        ->preload(),
                ])->columns(3)->collapsible()->iconColor('primary')->icon('heroicon-s-document-duplicate'),
                Section::make([
                    Forms\Components\TextInput::make('discount_percentage')
                        ->label('Diskon (persen)')
                        ->required()
                        ->numeric()
                        ->default(0),
                    Forms\Components\TextInput::make('ppn_percentage')
                        ->label('Ppn')
                        ->required()
                        ->numeric()
                        ->default(11),
                    Forms\Components\TextInput::make('pph_percentage')
                        ->label('Pph')
                        ->required()
                        ->numeric()
                        ->default(0),
                ])->columns(4)->collapsible()->heading('Potongan')->iconColor('primary')->icon('heroicon-s-receipt-percent'),
                RichEditor::make('additional_description')
                    ->label('Keterangan tambahan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('quotation_number', 'desc')
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('request.code')
                    ->label('Nomor permohonan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation_number')
                    ->label('Kode penawaran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation_name')
                    ->label('Judul penawaran')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Nama perusahaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('personel.fullname')
                    ->label('Petugas pembuat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation_date')
                    ->label('Tanggal penawaran')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ppn_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pph_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation_status'),
                Tables\Columns\TextColumn::make('approved_by_user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime()
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
                SelectFilter::make('customer_id')
                    ->label('Klien')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('user_id')
                    ->label('Petugas')
                    ->relationship('personel', 'fullname')
                    ->searchable()
                    ->preload(),
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
            QuotationItemRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'view' => Pages\ViewQuotation::route('/{record}'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}
