<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\LabJob;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'default' => 1,
                'lg' => 2,
            ])
            ->components([
                Section::make('Informasi Tagihan')
                    ->schema([
                        DatePicker::make('date')
                            ->label('Tanggal')
                            ->required()
                            ->default(now())
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                function (Set $set, ?string $state): void {
                                    if (! $state) {
                                        return;
                                    }
                                    $set(
                                        'due_date',
                                        Carbon::parse($state)->addDays(30)
                                            ->format('Y-m-d')
                                    );
                                }
                            ),

                        DatePicker::make('due_date')
                            ->label('Jatuh Tempo')
                            ->required()
                            ->default(
                                now()->addDays(30)
                            )
                            ->afterOrEqual('date')
                            ->helperText(
                                'Otomatis 30 hari setelah tanggal tagihan.'
                            ),

                        Select::make('lab_job_id')
                            ->label('Lab Job')
                            ->relationship(
                                'labJob',
                                'code',
                                modifyQueryUsing: function (Builder $query, $record) {
                                    $currentInvoiceId = $record?->id;

                                    return $query->whereDoesntHave(
                                        'invoice',
                                        function (Builder $q) use ($currentInvoiceId) {
                                            if ($currentInvoiceId) {
                                                $q->where('id', '!=', $currentInvoiceId);
                                            }
                                        }
                                    );
                                }
                            )
                            ->disabledOn(['view', 'edit'])
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                function (?string $state, Set $set): void {
                                    if (! $state) {
                                        $set('code', null);
                                        $set('subtotal', 0);
                                        self::setCalculatedTotals($set, 0, 0, 0, 0);
                                        return;
                                    }
                                    $labJob = LabJob::with(['labJobItems', 'quotation',])->find($state);
                                    if (! $labJob) {
                                        return;
                                    }
                                    $invoiceService = app(InvoiceService::class);
                                    /*
                                     * Generate nomor invoice
                                     */
                                    $set('code', $invoiceService->generateInvoiceNumber($labJob));
                                    /*
                                     * Preview subtotal.
                                     *
                                     * Nilai final tetap dihitung
                                     * kembali oleh InvoiceService
                                     * saat invoice dibuat.
                                     */
                                    $subtotal = $labJob
                                        ->labJobItems
                                        ->sum(fn($item) => (float) $item->quantity *  (float) $item->price);
                                    $set('subtotal', round($subtotal, 2));
                                    /*
                                     * Ambil tarif dari quotation.
                                     */
                                    $quotation = $labJob->quotation;
                                    $discountPercentage = (float) ($quotation?->discount_percentage ?? 0);
                                    $ppnPercentage = (float) ($quotation?->ppn_percentage ?? 0);
                                    $pphPercentage = (float) ($quotation?->pph_percentage ?? 0);

                                    /*
                                     * Hitung preview financial.
                                     */
                                    self::setCalculatedTotals(
                                        $set,
                                        $subtotal,
                                        $discountPercentage,
                                        $ppnPercentage,
                                        $pphPercentage
                                    );
                                }
                            )
                            ->columnSpan(1),

                        TextInput::make('code')
                            ->label('Nomor Tagihan')
                            ->required()
                            ->unique(
                                ignoreRecord: true
                            )
                            ->disabled(
                                fn(Get $get): bool => ! $get('manual_invoice_confirmation')
                            ),

                        Checkbox::make('manual_invoice_confirmation')
                            ->label('Input nomor tagihan manual')
                            ->dehydrated(false)
                            ->live(onBlur: true)
                            ->inline()
                            ->visibleOn('create')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->columnSpanFull()->inlineLabel(),

                /*
                 * ==========================================
                 * PERHITUNGAN TAGIHAN
                 * ==========================================
                 */
                Section::make('Perhitungan Tagihan')
                    ->schema([

                        // =========================
                        // SUBTOTAL
                        // =========================
                        Placeholder::make('dpp_display')
                            ->label('DPP')
                            ->content(
                                fn(Get $get): string =>
                                self::formatMoney(
                                    $get('dpp_amount')
                                )
                            ),


                        // =========================
                        // DISKON
                        // =========================

                        TextInput::make('discount_percentage')
                            ->label('Diskon')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix(
                                fn(Get $get): string =>
                                '% • ' . self::formatMoney(
                                    $get('discount_amount')
                                )
                            )
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(Get $get, Set $set) =>
                                self::calculateTotalsFromState($get, $set)
                            ),

                        // =========================
                        // PPN
                        // =========================

                        TextInput::make('ppn_percentage')
                            ->label('PPN')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix(
                                fn(Get $get): string =>
                                '% • ' . self::formatMoney(
                                    $get('ppn_amount')
                                )
                            )
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(Get $get, Set $set) =>
                                self::calculateTotalsFromState($get, $set)
                            ),

                        // =========================
                        // PPh 23
                        // =========================

                        TextInput::make('pph_percentage')
                            ->label('PPh 23')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix(
                                fn(Get $get): string =>
                                '% • ' . self::formatMoney(
                                    $get('pph_amount')
                                )
                            )
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(Get $get, Set $set) =>
                                self::calculateTotalsFromState($get, $set)
                            ),

                        // =========================
                        // HASIL KALKULASI
                        // =========================
                        Placeholder::make('subtotal_display')
                            ->label('Subtotal')
                            ->content(
                                fn(Get $get): HtmlString => new HtmlString(
                                    '
                                        <div style="
                                            padding: 14px 18px;
                                            border: 1px solid #e5e7eb;
                                            border-radius: 8px;
                                            background: #f9fafb;
                                        ">
                                            <div style="
                                                font-size: 13px;
                                                color: #6b7280;
                                                margin-bottom: 4px;
                                            ">
                                                Subtotal
                                            </div>

                                            <div style="
                                                font-size: 20px;
                                                font-weight: 600;
                                                line-height: 1.4;
                                                color: #111827;
                                            ">
                                                ' . self::formatMoney($get('subtotal')) . '
                                            </div>
                                        </div>
                                        '
                                )
                            )
                            ->columnSpan(1),

                        Placeholder::make('total_display')
                            ->label('Total Tagihan')
                            ->content(
                                fn(Get $get): HtmlString => new HtmlString(
                                    '
                                    <div style="
                                        padding: 16px 20px;
                                        border: 1px solid #d1d5db;
                                        border-radius: 8px;
                                        background: #f3f4f6;
                                    ">
                                        <div style="
                                            font-size: 13px;
                                            color: #6b7280;
                                            margin-bottom: 5px;
                                        ">
                                            Total Tagihan
                                        </div>

                                        <div style="
                                            font-size: 26px;
                                            font-weight: 700;
                                            line-height: 1.3;
                                            color: #111827;
                                        ">
                                            ' . self::formatMoney($get('total_amount')) . '
                                        </div>

                                        <div style="
                                            font-size: 11px;
                                            color: #6b7280;
                                            margin-top: 5px;
                                        ">
                                            DPP + PPN
                                        </div>
                                    </div>
                                    '
                                )
                            )
                            ->columnSpan(1),

                        Placeholder::make('net_display')
                            ->label('Total Bersih')
                            ->content(
                                fn(Get $get): HtmlString => new HtmlString(
                                    '
                                    <div style="
                                        padding: 16px 20px;
                                        border: 1px solid #d1d5db;
                                        border-radius: 8px;
                                        background: #f9fafb;
                                    ">
                                        <div style="
                                            font-size: 13px;
                                            color: #6b7280;
                                            margin-bottom: 5px;
                                        ">
                                            Total Bersih
                                        </div>

                                        <div style="
                                            font-size: 26px;
                                            font-weight: 700;
                                            line-height: 1.3;
                                            color: #111827;
                                        ">
                                            ' . self::formatMoney($get('net_amount')) . '
                                        </div>

                                        <div style="
                                            font-size: 11px;
                                            color: #6b7280;
                                            margin-top: 5px;
                                        ">
                                            Total Tagihan - PPh 23
                                        </div>
                                    </div>
                                    '
                                )
                            )
                            ->columnSpan(1),

                        // =========================
                        // HIDDEN VALUES
                        // =========================

                        Hidden::make('discount_amount')
                            ->default(0),
                        Hidden::make('dpp_amount')
                            ->default(0),
                        Hidden::make('ppn_amount')
                            ->default(0),
                        Hidden::make('pph_amount')
                            ->default(0),
                        Hidden::make('total_amount')
                            ->default(0),
                        Hidden::make('net_amount')
                            ->default(0),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
            ]);
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
    ): void {
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
    ): void {
        $totals = app(InvoiceService::class)
            ->calculateTotals(
                subtotal: $subtotal,
                discountPercentage: $discountPercentage,
                ppnPercentage: $ppnPercentage,
                pphPercentage: $pphPercentage,
            );

        foreach ($totals as $key => $value) {
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
