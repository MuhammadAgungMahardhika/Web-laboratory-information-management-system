<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Filament\Resources\QuotationResource\RelationManagers\QuotationItemRelationManager;
use App\Models\Enums\CustomerStatusEnum;
use App\Models\Enums\QuotationStatusEnum;
use App\Models\Enums\RoleEnum;
use App\Models\Quotation;
use App\Models\TermTemplate;
use App\Services\QuotationService;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
                        ->label('Tanggal Penawaran')
                        ->default(now())
                        ->displayFormat('d/m/Y')
                        ->native(false)
                        ->required()
                        ->reactive() // <-- Tambahkan ini agar perubahan memicu update field lain
                        ->afterStateUpdated(function ($state, Forms\Set $set) { // <-- Tambahkan ini
                            // Jika quotation_date diisi, set valid_until_date menjadi 30 hari setelahnya
                            if ($state) {
                                $set('valid_until_date', \Carbon\Carbon::parse($state)->addDays(30));
                            } else {
                                // Jika quotation_date dikosongkan, kosongkan juga valid_until_date
                                $set('valid_until_date', null);
                            }
                        }),

                    Forms\Components\DatePicker::make('valid_until_date')
                        ->label('Tanggal Berakhir Penawaran')
                        ->default(now()->addDays(30)) // Default awal saat form dibuka
                        ->displayFormat('d/m/Y')
                        ->native(false)
                        ->minDate(function (Forms\Get $get) {
                            $quotationDate = $get('quotation_date');
                            return $quotationDate ? \Carbon\Carbon::parse($quotationDate)->addDay() : null;
                        })
                        ->required()
                        ->helperText('Default 30 hari setelah tanggal penawaran'),
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
                                        ->default(QuotationStatusEnum::default()),
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
                    ])->columns(3)->collapsible()->heading('Potongan')->iconColor('primary')->icon('heroicon-s-receipt-percent')->columnSpan(1)->iconPosition('after'),
                ])->columns(3)->collapsible()->iconColor('primary')->icon('heroicon-s-document-duplicate'),

                Forms\Components\Section::make('Syarat & Ketentuan Pembayaran')
                    ->description('Pilih template atau tulis syarat & ketentuan secara manual.')
                    ->schema([
                        Select::make('template_selector')
                            ->label('Pilih Template')
                            // --- PENTING: Opsi diambil dari database untuk menampilkan NAMA TEMPLATE ---
                            ->options(function () {
                                $options = TermTemplate::query()
                                    ->where('is_active', true)
                                    ->pluck('name', 'id') // Mengambil 'name' sebagai label dan 'id' sebagai value
                                    ->toArray();
                                // Tambahkan opsi "Kosongkan" secara manual
                                $options['kosong'] = 'Kosongkan';
                                return $options;
                            })
                            ->searchable()
                            // -------------------------------------------------------------------------
                            ->placeholder('Atau tulis manual di bawah')
                            ->reactive()
                            ->afterStateUpdated(function (?string $state, Get $get, Set $set) {
                                if ($state === 'kosong') {
                                    $set('additional_description', ''); // Kosongkan jika 'kosong' dipilih
                                } elseif ($state) {
                                    // --- Mengambil KONTEN template dari database berdasarkan ID yang dipilih ---
                                    $template = TermTemplate::find($state);
                                    if ($template) {
                                        $set('additional_description', $template->content);
                                    } else {
                                        // Fallback jika template tidak ditemukan (misal: ID tidak valid)
                                        $set('additional_description', '');
                                    }
                                } else {
                                    // Jika pilihan dikosongkan tanpa memilih 'kosong'
                                    $set('additional_description', null);
                                }
                            })
                            ->dehydrated(false),

                        RichEditor::make('additional_description')
                            ->label('')
                            ->columnSpanFull()
                            ->toolbarButtons([ // Atur toolbar RichEditor
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'strike',
                                'underline',
                            ]),
                    ]),
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
                Tables\Columns\TextColumn::make('quotation_date')
                    ->label('Tanggal penawaran')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_until_date')
                    ->label('Tanggal berakhir penawaran')
                    ->date('d M Y')
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

                Tables\Columns\TextColumn::make('discount_percentage')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ppn_percentage')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pph_percentage')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Jumlah total')
                    ->numeric()
                    ->money('IDR', true)
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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
                // --- Filter Tanggal Penawaran (quotation_date) ---
                Filter::make('quotation_date_range')
                    ->form([
                        Section::make([
                            DatePicker::make('from')
                                ->label('Tanggal Penawaran Mulai')
                                ->displayFormat('d/m/Y'),
                            DatePicker::make('until')
                                ->label('Tanggal Penawaran Sampai')
                                ->displayFormat('d/m/Y'),
                        ])->columns(2)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date) => $query->where('quotation_date', '>=', Carbon::parse($date)->startOfDay()),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date) => $query->where('quotation_date', '<=', Carbon::parse($date)->endOfDay()),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators['from'] = 'Penawaran dari ' . Carbon::parse($data['from'])->format('d M Y');
                        }
                        if ($data['until'] ?? null) {
                            $indicators['until'] = 'Penawaran sampai ' . Carbon::parse($data['until'])->format('d M Y');
                        }
                        return $indicators;
                    })->columnSpan(2),
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


    public static function canEdit(Model $record): bool
    {
        return in_array($record->status, [
            QuotationStatusEnum::Draft->value,
            QuotationStatusEnum::PendingResponse->value,
            QuotationStatusEnum::Revised->value,
        ]);
    }

    public static function canDelete(Model $record): bool
    {
        return in_array($record->status, [
            QuotationStatusEnum::Draft->value,
            QuotationStatusEnum::PendingResponse->value,
            QuotationStatusEnum::Revised->value,
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
