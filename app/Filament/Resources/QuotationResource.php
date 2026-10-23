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
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Enums\RecordActionsPosition;

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
        $personel   = Auth::user()?->personel;
        $expiryDays = (int) ($personel?->company?->active_setting?->default_quotation_expiry_days ?? 30);

        return $schema
            ->columns(1)
            ->components([

                // Badge status, hanya muncul saat penawaran sudah ada
                TextEntry::make('status_badge')
                    ->hiddenLabel()
                    ->badge()
                    ->state(fn($record) => QuotationStatusEnum::labels()[$record->status] ?? null)
                    ->color(fn($record) => $record?->status ? QuotationStatusEnum::color($record->status) : 'gray')
                    ->icon(Heroicon::DocumentCheck)
                    ->visible(fn($record) => filled($record?->status)),

                Tabs::make()
                    ->persistTabInQueryString()
                    ->columnSpanFull()
                    ->tabs([

                        /* ───────────── Tab 1: Penawaran ───────────── */
                        Tab::make('Penawaran')
                            ->icon(Heroicon::DocumentDuplicate)
                            ->schema([
                                Grid::make(['default' => 2, 'lg' => 12])->schema([

                                    TextInput::make('code')
                                        ->label('Nomor')
                                        ->prefixIcon(Heroicon::Hashtag)
                                        ->default(fn() => app(QuotationService::class)->generateQuotationNumber())
                                        ->required()
                                        ->maxLength(50)
                                        ->columnSpan(['default' => 2, 'lg' => 4]),

                                    DatePicker::make('date')
                                        ->label('Tanggal')
                                        ->prefixIcon(Heroicon::CalendarDays)
                                        ->default(now())
                                        ->native(false)
                                        ->displayFormat('d/m/Y')
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(fn($state, Set $set) => $set(
                                            'valid_until_date',
                                            $state ? Carbon::parse($state)->addDays($expiryDays) : null
                                        ))
                                        ->columnSpan(['default' => 1, 'lg' => 4]),

                                    DatePicker::make('valid_until_date')
                                        ->label('Berlaku sampai')
                                        ->prefixIcon(Heroicon::Clock)
                                        ->default(now()->addDays($expiryDays))
                                        ->native(false)
                                        ->displayFormat('d/m/Y')
                                        ->minDate(fn(Get $get) => $get('date')
                                            ? Carbon::parse($get('date'))->addDay()
                                            : null)
                                        ->required()
                                        ->live()
                                        // Hint singkat: berapa hari masa berlaku penawaran
                                        ->hint(function (Get $get): ?string
                                        {
                                            if (! $get('date') || ! $get('valid_until_date'))
                                            {
                                                return null;
                                            }

                                            $days = Carbon::parse($get('date'))
                                                ->startOfDay()
                                                ->diffInDays(Carbon::parse($get('valid_until_date'))->startOfDay());

                                            return $days . ' hari';
                                        })
                                        ->hintColor('gray')
                                        ->columnSpan(['default' => 1, 'lg' => 4]),

                                    TextInput::make('name')
                                        ->label('Judul')
                                        ->placeholder('Judul penawaran')
                                        ->required()
                                        ->columnSpanFull(),

                                    Select::make('customer_id')
                                        ->label('Klien')
                                        ->prefixIcon(Heroicon::BuildingOffice)
                                        ->relationship('customer', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->createOptionModalHeading('Klien baru')
                                        ->createOptionForm(self::customerFields())
                                        ->columnSpan(['default' => 2, 'lg' => 6]),

                                    Select::make('personel_id')
                                        ->label('Petugas')
                                        ->prefixIcon(Heroicon::UserCircle)
                                        ->relationship('personel', 'fullname')
                                        ->default($personel?->id)
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->columnSpan(['default' => 2, 'lg' => 3]),

                                    Select::make('request_id')
                                        ->label('No. permohonan')
                                        ->prefixIcon(Heroicon::ClipboardDocumentList)
                                        ->relationship('request', 'request_number')
                                        ->searchable()
                                        ->preload()
                                        ->placeholder('Opsional')
                                        ->columnSpan(['default' => 2, 'lg' => 3]),

                                    // Potongan: selalu 3 kolom, angka kecil jadi muat di mobile
                                    Grid::make(3)
                                        ->columnSpanFull()
                                        ->schema([
                                            self::percentageInput('discount_percentage', 'Diskon', 0, Heroicon::ReceiptPercent),
                                            self::percentageInput('ppn_percentage', 'PPN', 11, Heroicon::Calculator),
                                            self::percentageInput('pph_percentage', 'PPh', 2, Heroicon::Scissors),
                                        ]),
                                ]),
                            ]),

                        /* ───────────── Tab 2: Syarat & ketentuan ───────────── */
                        Tab::make('Syarat & Ketentuan')
                            ->icon(Heroicon::DocumentText)
                            ->schema([
                                Select::make('template_selector')
                                    ->hiddenLabel()
                                    ->prefixIcon(Heroicon::Sparkles)
                                    ->placeholder('Gunakan template (opsional)')
                                    ->options(fn() => TermTemplate::query()
                                        ->where('is_active', true)
                                        ->pluck('name', 'id')
                                        ->toArray())
                                    ->searchable()
                                    ->live()
                                    ->dehydrated(false)
                                    ->afterStateUpdated(function (?string $state, Set $set)
                                    {
                                        if ($state && ($template = TermTemplate::find($state)))
                                        {
                                            $set('additional_description', $template->content);
                                        }
                                    })
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Nama template')
                                            ->required()
                                            ->unique(TermTemplate::class)
                                            ->maxLength(255),
                                        RichEditor::make('content')
                                            ->label('Isi')
                                            ->required()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'h2',
                                                'h3',
                                                'bulletList',
                                                'orderedList',
                                                'blockquote',
                                                'link',
                                            ]),
                                        Hidden::make('is_active')->default(true),
                                    ])
                                    ->createOptionUsing(fn(array $data) => (string) TermTemplate::create($data)->id),

                                RichEditor::make('additional_description')
                                    ->hiddenLabel()
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    protected static function percentageInput(string $name, string $label, int $default, $icon): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->prefixIcon($icon)
            ->numeric()
            ->default($default)
            ->minValue(0)
            ->maxValue(100)
            ->suffix('%')
            ->required();
    }

    /**
     * Form klien baru (modal): field wajib di atas, detail tambahan dilipat.
     */
    protected static function customerFields(): array
    {
        return [
            Grid::make(['default' => 1, 'sm' => 2])->schema([
                TextInput::make('name')
                    ->label('Nama klien')
                    ->prefixIcon(Heroicon::BuildingOffice)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('customer_type_id')
                    ->label('Jenis')
                    ->relationship('customerType', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('contact_person_name')
                    ->label('Narahubung')
                    ->prefixIcon(Heroicon::User)
                    ->required()
                    ->maxLength(255),

                TextInput::make('contact_phone_number')
                    ->label('No. HP')
                    ->prefixIcon(Heroicon::Phone)
                    ->tel()
                    ->required()
                    ->maxLength(255),

                TextInput::make('contact_email')
                    ->label('Email')
                    ->prefixIcon(Heroicon::Envelope)
                    ->email(),

                Hidden::make('registration_date')->default(now()),
                Hidden::make('status')->default(QuotationStatusEnum::default()),
            ]),

            Section::make('Detail lainnya')
                ->icon(Heroicon::MapPin)
                ->compact()
                ->collapsible()
                ->collapsed()
                ->columns(['default' => 1, 'sm' => 2])
                ->schema([
                    TextInput::make('contact_person_title')->label('Jabatan')->maxLength(255),
                    TextInput::make('npwp')->label('NPWP')->maxLength(255),

                    Select::make('province_id')
                        ->label('Provinsi')
                        ->relationship('province', 'name')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(fn(Set $set) => $set('city_id', null)),

                    Select::make('city_id')
                        ->label('Kota')
                        ->relationship(
                            'city',
                            'name',
                            modifyQueryUsing: fn($query, Get $get) => $query->where('province_id', $get('province_id'))
                        )
                        ->searchable()
                        ->preload(),

                    TextInput::make('full_address')
                        ->label('Alamat')
                        ->maxLength(255)
                        ->columnSpan(['default' => 1, 'sm' => 2]),

                    TextInput::make('postal_code')->label('Kode pos')->maxLength(255),

                    Select::make('user_id')
                        ->label('Akun pelanggan')
                        ->relationship(
                            'user',
                            'name',
                            modifyQueryUsing: fn($query) => $query
                                ->whereDoesntHave('customer')
                                ->whereDoesntHave('personel')
                        )
                        ->searchable()
                        ->preload(),
                ]),
        ];
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
                        query: function (Builder $query, string $search): Builder
                        {
                            return $query->where(function ($q) use ($search)
                            {
                                $q->where('code', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%");
                            });
                        }
                    )->formatStateUsing(function ($state, $record)
                    {
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
                        query: function (Builder $query, string $search): Builder
                        {
                            return $query->where(function ($q) use ($search)
                            {

                                $q->whereHas('customer', function ($sub) use ($search)
                                {
                                    $sub->where('name', 'like', "%{$search}%");
                                })
                                    ->orWhereHas('personel', function ($sub) use ($search)
                                    {
                                        $sub->where('fullname', 'like', "%{$search}%");
                                    });
                            });
                        }
                    )
                    ->formatStateUsing(function ($state, $record): string
                    {

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
                        query: function (Builder $query, string $direction)
                        {

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
                        query: function (Builder $query, string $search): Builder
                        {
                            return $query->whereExists(function ($sub) use ($search)
                            {
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
                    ->formatStateUsing(function ($state, $record)
                    {

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
                        query: function (Builder $query, string $search): Builder
                        {

                            return $query->whereHas(
                                'approvedByPersonel',
                                fn($q) => $q->where('fullname', 'like', "%{$search}%")
                            );
                        }
                    )
                    ->formatStateUsing(function ($state, $record): string
                    {

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
                        query: function (Builder $query, string $search): Builder
                        {

                            return $query->where(function ($q) use ($search)
                            {

                                $q->where('created_by', 'like', "%{$search}%")
                                    ->orWhere('updated_by', 'like', "%{$search}%");
                            });
                        }
                    )
                    ->formatStateUsing(function ($state, $record): string
                    {

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
                    ->query(function (Builder $query, array $data): Builder
                    {
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
                    ->indicateUsing(function (array $data): array
                    {
                        $indicators = [];
                        if ($data['from'] ?? null)
                        {
                            $indicators['from'] = 'Penawaran dari ' . Carbon::parse($data['from'])->format('d M Y');
                        }
                        if ($data['until'] ?? null)
                        {
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
