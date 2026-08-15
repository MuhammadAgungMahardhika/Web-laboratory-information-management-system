<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Actions\QuotationStatusAction;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use App\Filament\Resources\QuotationResource\Pages\ListQuotations;
use App\Filament\Resources\QuotationResource\Pages\CreateQuotation;
use App\Filament\Resources\QuotationResource\Pages\ViewQuotation;
use App\Filament\Resources\QuotationResource\Pages\EditQuotation;
use App\Filament\Resources\QuotationResource\RelationManagers\QuotationItemRelationManager;
use App\Models\Enums\QuotationStatusEnum;
use App\Models\Enums\RoleEnum;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\TermTemplate;
use App\Services\QuotationService;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Enums\RecordActionsPosition;
use Illuminate\Support\HtmlString;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationLabel = 'Penawaran';
    protected static ?string $label = 'Penawaran';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'code';
    protected static int $globalSearchResultsLimit = 20;
    protected static ?int $draftCount = null;

    protected static function draftCount(): int
    {
        return static::$draftCount ??=
            static::getEloquentQuery()
            ->where('status', QuotationStatusEnum::Draft->value)
            ->count();
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::draftCount();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::draftCount() > 0
            ? 'gray'
            : 'success';
    }


    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'name', 'customer.name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->code;
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Nomor' => $record->code,
            'Judul' => $record->name,
            'Klien' => $record->customer->name,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['customer']);
    }
    public static function form(Schema $schema): Schema
    {
        $user = Auth::user();
        $setting  =   $user->personel->company->active_setting;
        $personelId =   $user->personel->id ?? null;
        $defaultQuotationExpiryDays = (int) $setting->default_quotation_expiry_days;
        $quoatationService = app(QuotationService::class);
        return $schema
            ->columns([
                'default' => 1,
                'lg' => 2,
            ])
            ->components([
                Section::make([
                    DatePicker::make('date')
                        ->label('Tanggal penawaran')
                        ->default(now())
                        ->displayFormat('d/m/Y')
                        ->native(false)
                        ->required()
                        ->reactive() // <-- Tambahkan ini agar perubahan memicu update field lain
                        ->afterStateUpdated(function ($state, Set $set) use ($defaultQuotationExpiryDays) { // <-- Tambahkan ini
                            // Jika date diisi, set valid_until_date menjadi 30 hari setelahnya
                            if ($state) {
                                $set('valid_until_date', Carbon::parse($state)->addDays($defaultQuotationExpiryDays));
                            } else {
                                // Jika date dikosongkan, kosongkan juga valid_until_date
                                $set('valid_until_date', null);
                            }
                        }),
                    DatePicker::make('valid_until_date')
                        ->label('Tanggal berakhir penawaran')
                        ->default(now()->addDays(30)) // Default awal saat form dibuka
                        ->displayFormat('d/m/Y')
                        ->native(false)
                        ->minDate(function (Get $get) {
                            $quotationDate = $get('date');
                            return $quotationDate ? Carbon::parse($quotationDate)->addDay() : null;
                        })
                        ->required()
                        ->helperText(fn() => "Default {$defaultQuotationExpiryDays} hari"),
                    TextInput::make('code')
                        ->label('Nomor penawaran')
                        ->required()
                        ->default($quoatationService->generateQuotationNumber())
                        ->maxLength(50),
                    Select::make('request_id')
                        ->label('Nomor permohonan (jika ada)')
                        ->relationship('request', 'request_number'),
                    TextInput::make('name')
                        ->label('Judul penawaran')
                        ->columnSpan(2)
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
                                    TextInput::make('name')
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
                                    TextInput::make('full_address')
                                        ->label('Alamat lengkap')
                                        ->maxLength(255),
                                    TextInput::make('postal_code')
                                        ->label('Kode pos')
                                        ->maxLength(255),
                                ])->columns(4)->collapsible()->heading('Alamat')->iconColor('primary')->icon('heroicon-s-map-pin'),

                                Section::make([
                                    TextInput::make('contact_person_name')
                                        ->label('Nama')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('contact_phone_number')
                                        ->label('Nomor hp')
                                        ->required()
                                        ->tel()
                                        ->maxLength(255),
                                    TextInput::make('contact_person_title')
                                        ->label('Jabatan')
                                        ->maxLength(255),

                                    TextInput::make('contact_email')
                                        ->label('Email')
                                        ->email(),
                                    TextInput::make('npwp')
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
                        ->relationship('personel', 'fullname')
                        ->default($personelId ?? null)
                        ->searchable()
                        ->preload(),

                    Section::make([
                        TextInput::make('discount_percentage')
                            ->label('Diskon (%)')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('ppn_percentage')
                            ->label('Ppn (%)')
                            ->required()
                            ->numeric()
                            ->default(11),
                        TextInput::make('pph_percentage')
                            ->label('Pph (%)')
                            ->required()
                            ->numeric()
                            ->default(2),
                    ])->columns([
                        'default' => 1,
                        'md' => 3,
                    ])->collapsible()->heading('Potongan')->icon(Heroicon::ReceiptPercent),
                    Section::make([
                        Select::make('template_selector')
                            ->label('Pilih Template')
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
                                    $set('additional_description', null); // Kosongkan jika 'kosong' dipilih
                                } elseif ($state) {
                                    // --- Mengambil KONTEN template dari database berdasarkan ID yang dipilih ---
                                    $template = TermTemplate::find($state);
                                    if ($template) {
                                        $set('additional_description', $template->content);
                                    } else {
                                        // Fallback jika template tidak ditemukan (misal: ID tidak valid)
                                        $set('additional_description', null);
                                    }
                                } else {
                                    // Jika pilihan dikosongkan tanpa memilih 'kosong'
                                    $set('additional_description', null);
                                }
                            })
                            ->dehydrated(false)
                            ->createOptionForm(function (Get $get, Set $set) {
                                return [
                                    TextInput::make('name')
                                        ->label('Nama Template')
                                        ->required()
                                        ->unique(TermTemplate::class)
                                        ->maxLength(255),
                                    RichEditor::make('content')
                                        ->label('Isi Template')
                                        ->required()
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
                                    Hidden::make('is_active')
                                        ->label('Aktif ?')
                                        ->required()
                                        ->default(true),
                                ];
                            })->createOptionUsing(function (array $data): string {
                                // Logika ini akan membuat record baru di database
                                $template = TermTemplate::create($data);
                                return (string) $template->id; // Mengembalikan ID dari record yang baru dibuat
                            }),

                        RichEditor::make('additional_description')
                            ->label('')
                            ->required()
                            ->autofocus()
                            ->columnSpanFull(),
                    ])->columns(1)->collapsible()->collapsed()->heading('Syarat & Ketentuan')->icon(Heroicon::DocumentText)->iconColor('success')->description('Pilih template atau tulis syarat & ketentuan secara manual.'),


                ])->columns([
                    'default' => 1,
                    'lg' => 2,
                ])
                    ->columnSpanFull()->heading(fn($record) => $record && $record->status ?  'Status -> ' . QuotationStatusEnum::labels()[$record->status] : 'Buat Penawaran Baru')
                    ->collapsible()->iconColor(fn($record) =>  $record && $record->status ? QuotationStatusEnum::color($record->status) : 'primary')->icon('heroicon-s-document-duplicate'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->selectCurrentPageOnly()
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => QuotationStatusEnum::from($state)->label())
                    ->badge()
                    ->color(fn($state) => QuotationStatusEnum::color($state))
                    ->sortable()
                    ->searchable(),
                // TextColumn::make('request.code')
                //     ->label('Nomor permohonan')
                //     ->searchable()
                //     ->sortable(),
                TextColumn::make('code')
                    ->label('Penawaran')
                    ->html()
                    ->sortable()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->where(function ($q) use ($search) {
                                $q->where('code', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%");
                            });
                        }
                    )->formatStateUsing(function ($state, $record) {

                        $quotationDate = $record->date
                            ? Carbon::parse($record->date)->format('d M Y')
                            : '-';

                        $validUntil = $record->valid_until_date
                            ? Carbon::parse($record->valid_until_date)->format('d M Y')
                            : '-';

                        return new \Illuminate\Support\HtmlString("
        <div style='line-height:1.45'>
            <div style='font-weight:700;color:#2563eb'>
                {$record->code}
            </div>

            <div style='font-size:12px;color:#6b7280'>
                {$record->name}
            </div>

            <div style='font-size:12px;margin-top:6px'>
                {$quotationDate}
                &nbsp;&rarr;&nbsp;
                {$validUntil}
            </div>
        </div>
    ");
                    }),
                TextColumn::make('customer.name')
                    ->label('Klien')
                    ->html()
                    ->sortable()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->where(function ($q) use ($search) {

                                $q->whereHas('customer', function ($sub) use ($search) {
                                    $sub->where('name', 'like', "%{$search}%");
                                })
                                    ->orWhereHas('personel', function ($sub) use ($search) {
                                        $sub->where('fullname', 'like', "%{$search}%");
                                    });
                            });
                        }
                    )
                    ->formatStateUsing(function ($state, $record): string {

                        return "
            <div>
                <div class='font-semibold'>
                    {$record->customer?->name}
                </div>

                <div class='text-xs text-gray-500'>
                    {$record->personel?->fullname}
                </div>
            </div>
        ";
                    }),
                TextColumn::make('total_price')
                    ->label('Nominal')
                    ->html()
                    ->sortable(
                        query: function (Builder $query, string $direction) {

                            return $query->orderBy(
                                QuotationItem::selectRaw('COALESCE(SUM(quantity * price),0)')
                                    ->whereColumn(
                                        'quotation_items.quotation_id',
                                        'quotations.id'
                                    ),
                                $direction
                            );
                        }
                    )
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->whereExists(function ($sub) use ($search) {
                                $sub->selectRaw(1)
                                    ->from('quotation_items')
                                    ->whereColumn('quotation_items.quotation_id', 'quotations.id')
                                    ->groupBy('quotation_items.quotation_id')
                                    ->havingRaw(
                                        'COALESCE(SUM(quantity * price), 0) LIKE ?',
                                        ["%{$search}%"]
                                    );
                            });
                        }
                    )
                    ->alignEnd()
                    ->formatStateUsing(function ($state, $record) {

                        $total = number_format($record->total_price, 0, ',', '.');

                        return "
        <div style='text-align:right;line-height:1.45'>
            <div style='font-size:15px;font-weight:700;color:#16a34a'>
                Rp {$total}
            </div>

            <div style='font-size:12px;color:#6b7280'>
                Diskon {$record->discount_percentage}%
            </div>

            <div style='font-size:12px;color:#6b7280'>
                PPN {$record->ppn_percentage}% &nbsp;|&nbsp; PPh {$record->pph_percentage}%
            </div>
        </div>";
                    }),

                TextColumn::make('approvedByPersonel.fullname')
                    ->label('Approval')
                    ->html()
                    ->sortable()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {

                            return $query->whereHas(
                                'approvedByPersonel',
                                fn($q) => $q->where('fullname', 'like', "%{$search}%")
                            );
                        }
                    )
                    ->formatStateUsing(function ($state, $record): string {

                        $tanggal = optional($record->approved_at)->format('d M Y H:i');

                        return "
            <div>
                <div class='font-semibold'>
                    " . ($record->approvedByPersonel?->fullname ?? '-') . "
                </div>

                <div class='text-xs text-gray-500'>
                    {$tanggal}
                </div>
            </div>
        ";
                    }),
                TextColumn::make('created_by')
                    ->label('Audit')
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {

                            return $query->where(function ($q) use ($search) {

                                $q->where('created_by', 'like', "%{$search}%")
                                    ->orWhere('updated_by', 'like', "%{$search}%");
                            });
                        }
                    )
                    ->formatStateUsing(function ($state, $record): string {

                        return "
            <div>
                <div>
                    <strong>Create :</strong> {$record->created_by}
                </div>

                <div class='text-xs text-gray-500'>
                    Update : {$record->updated_by}
                </div>
            </div>
        ";
                    }),
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
                // --- Filter Tanggal Penawaran (date) ---
                Filter::make('quotation_date_range')
                    ->schema([
                        DatePicker::make('from')
                            ->label('Tanggal Mulai')
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('until')
                            ->label('Tanggal Akhir')
                            ->displayFormat('d/m/Y'),

                    ])
                    ->columns(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date) => $query->where('date', '>=', Carbon::parse($date)->startOfDay()),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date) => $query->where('date', '<=', Carbon::parse($date)->endOfDay()),
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
            ->recordActions([
                QuotationStatusAction::preview(),
                ViewAction::make(),
                EditAction::make(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
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
            'index' => ListQuotations::route('/'),
            'create' => CreateQuotation::route('/create'),
            'view' => ViewQuotation::route('/{record}'),
            'edit' => EditQuotation::route('/{record}/edit'),
        ];
    }
}
