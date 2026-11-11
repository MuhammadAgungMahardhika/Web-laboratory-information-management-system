<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\Enums\InvoiceStatusEnum;
use App\Models\LabJob;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(['default' => 1, 'lg' => 12])
                    ->columnSpanFull()
                    ->schema([

                        /* ───────────── KIRI: input ───────────── */
                        Section::make('Tagihan')
                            ->icon(Heroicon::DocumentText)
                            ->compact()
                            ->columns(['default' => 2])
                            ->columnSpan(['default' => 1, 'lg' => 7])
                            ->schema([

                                Select::make('lab_job_id')
                                    ->label('Lab Job')
                                    ->prefixIcon(Heroicon::Beaker)
                                    ->relationship(
                                        'labJob',
                                        'code',
                                        modifyQueryUsing: fn(Builder $query, $record) => $query->whereDoesntHave(
                                            'invoice',
                                            fn(Builder $q) => $record?->id
                                                ? $q->where('id', '!=', $record->id)
                                                : $q
                                        )
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabledOn(['view', 'edit'])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (?string $state, Set $set): void
                                    {
                                        if (! $state)
                                        {
                                            $set('code', null);
                                            $set('subtotal', 0);
                                            self::setCalculatedTotals($set, 0, 0, 0, 0);
                                            return;
                                        }

                                        $labJob = LabJob::with(['labJobItems', 'quotation'])->find($state);

                                        if (! $labJob)
                                        {
                                            return;
                                        }

                                        $set('code', app(InvoiceService::class)->generateInvoiceNumber($labJob));

                                        // Preview saja. Nilai final tetap dihitung ulang oleh InvoiceService.
                                        $subtotal = $labJob->labJobItems
                                            ->sum(fn($item) => (float) $item->quantity * (float) $item->price);

                                        $set('subtotal', round($subtotal, 2));

                                        $quotation = $labJob->quotation;

                                        self::setCalculatedTotals(
                                            $set,
                                            $subtotal,
                                            (float) ($quotation?->discount_percentage ?? 0),
                                            (float) ($quotation?->ppn_percentage ?? 0),
                                            (float) ($quotation?->pph_percentage ?? 0),
                                        );
                                    })
                                    ->columnSpanFull(),

                                // Nomor + checkbox manual dalam satu kolom
                                Group::make([
                                    TextInput::make('code')
                                        ->label('Nomor')
                                        ->prefixIcon(Heroicon::Hashtag)
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->disabled(fn(Get $get): bool => ! $get('manual_invoice_confirmation'))
                                        ->dehydrated(),

                                    Checkbox::make('manual_invoice_confirmation')
                                        ->label('Isi nomor manual')
                                        ->dehydrated(false)
                                        ->live()
                                        ->visibleOn('create'),
                                ])->columnSpanFull(),

                                DatePicker::make('date')
                                    ->label('Tanggal')
                                    ->prefixIcon(Heroicon::CalendarDays)
                                    ->default(now())
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, ?string $state): void
                                    {
                                        if ($state)
                                        {
                                            $set('due_date', Carbon::parse($state)->addDays(30)->format('Y-m-d'));
                                        }
                                    }),

                                DatePicker::make('due_date')
                                    ->label('Jatuh tempo')
                                    ->prefixIcon(Heroicon::Clock)
                                    ->default(now()->addDays(30))
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->afterOrEqual('date')
                                    ->required()
                                    ->live()
                                    // Peringatan hanya saat edit/view (invoice sudah ada)
                                    ->hint(fn(Get $get, string $operation): ?string => $operation === 'create'
                                        ? null
                                        : self::dueDateHint($get('due_date'), $get('status')))
                                    ->hintIcon(fn(Get $get, string $operation) => $operation === 'create'
                                        ? null
                                        : (self::dueDays($get('due_date'), $get('status')) < 0 ? Heroicon::ExclamationTriangle : null))
                                    ->hintColor(fn(Get $get) => match (true)
                                    {
                                        self::dueDays($get('due_date'), $get('status')) < 0  => 'danger',
                                        self::dueDays($get('due_date'), $get('status')) <= 3 => 'warning',
                                        default                                              => 'gray',
                                    }),

                                // Potongan: tampil saat edit/view, 3 kolom sejajar
                                Grid::make(3)
                                    ->columnSpanFull()
                                    ->visibleOn(['edit', 'view'])
                                    ->schema([
                                        self::percentageInput('discount_percentage', 'Diskon', Heroicon::ReceiptPercent),
                                        self::percentageInput('ppn_percentage', 'PPN', Heroicon::Calculator),
                                        self::percentageInput('pph_percentage', 'PPh 23', Heroicon::Scissors),
                                    ]),
                            ]),

                        /* ───────────── KANAN: ringkasan ala struk ───────────── */
                        Section::make('Ringkasan')
                            ->icon(Heroicon::Banknotes)
                            ->iconColor('primary')
                            ->compact()
                            ->columnSpan(['default' => 1, 'lg' => 5])
                            ->schema([
                                self::summaryRow('subtotal_display', 'Subtotal', 'subtotal'),
                                self::summaryRow('discount_display', 'Diskon', 'discount_amount', 'danger', '– '),
                                self::summaryRow('dpp_display', 'DPP', 'dpp_amount'),
                                self::summaryRow('ppn_display', 'PPN', 'ppn_amount', null, '+ '),

                                // Total = pusat perhatian
                                TextEntry::make('total_display')
                                    ->label('Total tagihan')
                                    ->inlineLabel()
                                    ->state(fn(Get $get): string => self::formatMoney($get('total_amount')))
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold)
                                    ->color('primary')
                                    ->icon(Heroicon::Banknotes),

                                self::summaryRow('pph_display', 'PPh 23', 'pph_amount', 'warning', '– '),

                                TextEntry::make('net_display')
                                    ->label('Total bersih')
                                    ->inlineLabel()
                                    ->state(fn(Get $get): string => self::formatMoney($get('net_amount')))
                                    ->weight(FontWeight::Bold)
                                    ->color('success'),

                                TextEntry::make('status_display')
                                    ->label('Status')
                                    ->inlineLabel()
                                    ->badge()
                                    ->state(fn(Get $get): string => ($status = $get('status')) === null
                                        ? 'Draft'
                                        : InvoiceStatusEnum::from((int) $status)->label())
                                    ->color(fn(Get $get) => self::statusColor($get('status')))
                                    ->visibleOn(['edit', 'view']),
                                Hidden::make('status'),
                                Hidden::make('discount_amount')->default(0),
                                Hidden::make('dpp_amount')->default(0),
                                Hidden::make('ppn_amount')->default(0),
                                Hidden::make('pph_amount')->default(0),
                                Hidden::make('total_amount')->default(0),
                                Hidden::make('net_amount')->default(0),
                            ]),
                    ]),
            ]);
    }

    protected static function percentageInput(string $name, string $label, $icon): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->prefixIcon($icon)
            ->numeric()
            ->default(0)
            ->minValue(0)
            ->maxValue(100)
            ->suffix('%')
            ->live(onBlur: true)
            ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateTotalsFromState($get, $set));
    }

    /** Satu baris ringkasan kecil (label kiri, nilai kanan). */
    protected static function summaryRow(
        string $name,
        string $label,
        string $key,
        ?string $color = null,
        string $prefix = '',
    ): TextEntry
    {
        return TextEntry::make($name)
            ->label($label)
            ->inlineLabel()
            ->state(fn(Get $get): string => $prefix . self::formatMoney($get($key)))
            ->color($color ?? 'gray');
    }

    /** Selisih hari ke jatuh tempo (negatif = terlambat). */
    /** Selisih hari ke jatuh tempo (negatif = terlambat). 999 = tidak relevan. */
    protected static function dueDays(?string $dueDate, mixed $status = null): int
    {
        if (! $dueDate || InvoiceStatusEnum::isClosedValue($status))
        {
            return 999;
        }

        return (int) now()->startOfDay()->diffInDays(Carbon::parse($dueDate)->startOfDay(), false);
    }

    protected static function dueDateHint(?string $dueDate, mixed $status = null): ?string
    {
        $days = self::dueDays($dueDate, $status);

        return match (true)
        {
            $days === 999 => null,
            $days < 0     => 'Terlambat ' . abs($days) . ' hari',
            $days === 0   => 'Jatuh tempo hari ini',
            $days <= 3    => $days . ' hari lagi',
            default       => null,
        };
    }

    /**
     * Warna badge status. Memakai getColor() bila enum implement HasColor,
     * kalau tidak, abu-abu. Sesuaikan dengan enum kamu bila perlu.
     */
    protected static function statusColor(mixed $status): string
    {
        return $status === null
            ? 'gray'
            : InvoiceStatusEnum::color((int) $status);
    }


    /**
     * Tampilan nominal tanpa kotak/warna hardcode, jadi otomatis ikut dark mode.
     */
    protected static function moneyDisplay(string $name, string $label, string $key, bool $emphasis = false): Placeholder
    {
        return Placeholder::make($name)
            ->label($label)
            ->content(fn(Get $get): HtmlString => new HtmlString(sprintf(
                '<span style="font-weight:%d;font-size:%s">%s</span>',
                $emphasis ? 700 : 500,
                $emphasis ? '1.125rem' : '1rem',
                e(self::formatMoney($get($key)))
            )));
    }

    protected static function statusDisplay(): Placeholder
    {
        return Placeholder::make('status_display')
            ->label('Status')
            ->content(function (Get $get): HtmlString
            {
                $status = $get('status');

                if ($status === null)
                {
                    return new HtmlString('<span style="opacity:.5">-</span>');
                }

                $enum = InvoiceStatusEnum::from((int) $status);

                return new HtmlString(sprintf(
                    '<span style="font-weight:700;font-size:1.125rem;color:%s">%s</span>',
                    e(InvoiceStatusEnum::cssColor((int) $status)),
                    e($enum->label())
                ));
            });
    }
    /**
     * Hitung ulang nilai financial berdasarkan state form.
     *
     * Kalkulasi sebenarnya berada di InvoiceService.
     * Method ini hanya menjembatani state Filament
     * dengan InvoiceService.
     */
    protected static function calculateTotalsFromState(
        Get $get,
        Set $set
    ): void
    {
        self::setCalculatedTotals(
            $set,
            subtotal: (float) (
                $get('subtotal') ?? 0
            ),
            discountPercentage: (float) (
                $get('discount_percentage') ?? 0
            ),
            ppnPercentage: (float) (
                $get('ppn_percentage') ?? 0
            ),
            pphPercentage: (float) (
                $get('pph_percentage') ?? 0
            ),
        );
    }

    /**
     * Set hasil kalkulasi ke state Filament.
     */
    protected static function setCalculatedTotals(
        Set $set,
        float $subtotal,
        float $discountPercentage = 0,
        float $ppnPercentage = 0,
        float $pphPercentage = 0,
    ): void
    {
        $totals = app(InvoiceService::class)
            ->calculateTotals(
                subtotal: $subtotal,
                discountPercentage: $discountPercentage,
                ppnPercentage: $ppnPercentage,
                pphPercentage: $pphPercentage,
            );

        foreach ($totals as $key => $value)
        {
            $set($key, $value);
        }
    }

    /**
     * Format nominal Rupiah.
     */
    protected static function formatMoney(mixed $value): string
    {
        return 'Rp ' . number_format((float) ($value ?? 0), 2, ',', '.');
    }
}
