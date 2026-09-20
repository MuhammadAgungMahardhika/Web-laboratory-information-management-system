<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Filament\Resources\LabJobResource;
use App\Filament\Resources\QuotationResource;
use App\Models\Enums\InvoiceStatusEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitle(fn($record) => $record->code)
            ->columns([
                /*
             * TAGIHAN
             * Lab Job + Nomor Tagihan
             */
                TextColumn::make('code')
                    ->label('Tagihan')
                    ->html()
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state, $record)
                    {
                        $statusLabel = InvoiceStatusEnum::tryFrom(
                            (int) $record->status
                        )?->label() ?? 'Unknown';

                        $statusColor = InvoiceStatusEnum::cssColor(
                            (int) $record->status
                        );

                        return new HtmlString("
                        <div style='line-height:1.45'>
                            <div style='
                                font-weight:700;
                                color:#111827;
                            '>
                                {$record->code}
                            </div>
                            <div style='margin-top:5px'>
                                <span style='
                                    display:inline-block;
                                    padding:3px 8px;
                                    border-radius:999px;
                                    background:{$statusColor}20;
                                    color:{$statusColor};
                                    font-size:11px;
                                    font-weight:600;
                                    white-space:nowrap;
                                '>
                                    {$statusLabel}
                                </span>
                            </div>
                        </div>
                    ");
                    }),
                TextColumn::make('labJob.code')
                    ->label('Reference')
                    ->html()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder
                        {
                            return $query->whereHas('labJob', function ($q) use ($search)
                            {
                                $q->where('code', 'like', "%{$search}%")
                                    ->orWhereHas('quotation', function ($q) use ($search)
                                    {
                                        $q->where('code', 'like', "%{$search}%");
                                    });
                            });
                        }
                    )
                    ->formatStateUsing(function ($state, $record)
                    {
                        $labJob = $record->labJob;
                        if (!$labJob)
                        {
                            return new HtmlString("
                                <div style='font-size:12px;color:#9ca3af;'>
                                    -
                                </div>
                            ");
                        }

                        $labJobUrl = LabJobResource::getUrl('view', [
                            'record' => $labJob->id,
                        ]);
                        $quotation = $labJob->quotation;
                        $html = "
                            <div style='line-height:1.45'>
                                <div style='font-size:11px; color:#6b7280;'>
                                    Lab Job
                                </div>
                                <a href='{$labJobUrl}'
                                    target='_blank'
                                    style='
                                        font-size:12px;
                                        color:#2563eb;
                                        text-decoration:none;
                                        font-weight:600;
                                    '>
                                    {$labJob->code}
                                </a>";
                        if ($quotation)
                        {
                            $quotationUrl = QuotationResource::getUrl('view', [
                                'record' => $quotation->id,
                            ]);

                            $html .= "
                            <div style='
                                margin-top:5px;
                                padding-top:5px;
                                border-top:1px solid #e5e7eb;
                            '>
                                <div style='font-size:11px;color:#6b7280;'>
                                    Quotation
                                </div>

                                <a href='{$quotationUrl}'
                                    target='_blank'
                                    style='
                                        font-size:12px;
                                        color:#2563eb;
                                        text-decoration:none;
                                        font-weight:600;
                                    '>
                                    {$quotation->code}
                                </a>
                            </div>
                        ";
                        }
                        $html .= "</div>";
                        return new HtmlString($html);
                    }),
                /*
             * TANGGAL
             * Tanggal Tagihan + Jatuh Tempo
             */
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->html()
                    ->sortable()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder
                        {
                            return $query->where(function ($q) use ($search)
                            {
                                $q->whereDate('date', $search)
                                    ->orWhereDate('due_date', $search);
                            });
                        }
                    )
                    ->formatStateUsing(function ($state, $record)
                    {
                        $date = $record->date
                            ? Carbon::parse($record->date)->format('d M Y')
                            : '-';

                        $dueDate = $record->due_date
                            ? Carbon::parse($record->due_date)->format('d M Y')
                            : '-';

                        $remainingDays = null;

                        if ($record->due_date)
                        {
                            $remainingDays = Carbon::today()
                                ->diffInDays(
                                    Carbon::parse($record->due_date)->startOfDay(),
                                    false
                                );
                        }

                        if ($remainingDays === null)
                        {
                            $remainingText = 'Sisa hari: -';
                            $remainingColor = '#6b7280';
                        }
                        elseif ($remainingDays > 0)
                        {
                            $remainingText = "Sisa {$remainingDays} hari";
                            $remainingColor = $remainingDays <= 3
                                ? '#d97706'
                                : '#16a34a';
                        }
                        elseif ($remainingDays === 0)
                        {
                            $remainingText = 'Jatuh tempo hari ini';
                            $remainingColor = '#d97706';
                        }
                        else
                        {
                            $daysLate = abs($remainingDays);

                            $remainingText = "Terlambat {$daysLate} hari";
                            $remainingColor = '#dc2626';
                        }

                        return new HtmlString("
                        <div style='line-height:1.45'>
                            <div style='
                                font-weight:600;
                                color:#111827;
                            '>
                                {$date}
                            </div>

                            <div style='
                                font-size:12px;
                                color:#6b7280;
                                margin-top:2px;
                            '>
                                Jatuh tempo: {$dueDate}
                            </div>

                            <div style='
                                font-size:12px;
                                font-weight:600;
                                color:{$remainingColor};
                                margin-top:4px;
                            '>
                                {$remainingText}
                            </div>
                        </div>
                    ");
                    }),

                /*
                * RINCIAN
                * Subtotal + Diskon + DPP + PPN + PPh
                */
                TextColumn::make('subtotal')
                    ->label('Rincian')
                    ->html()
                    ->sortable()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder
                        {
                            return $query->where(function ($q) use ($search)
                            {
                                $q->where('subtotal', 'like', "%{$search}%")
                                    ->orWhere('discount_percentage', 'like', "%{$search}%")
                                    ->orWhere('discount_amount', 'like', "%{$search}%")
                                    ->orWhere('dpp_amount', 'like', "%{$search}%")
                                    ->orWhere('ppn_percentage', 'like', "%{$search}%")
                                    ->orWhere('ppn_amount', 'like', "%{$search}%")
                                    ->orWhere('pph_percentage', 'like', "%{$search}%")
                                    ->orWhere('pph_amount', 'like', "%{$search}%");
                            });
                        }
                    )
                    ->formatStateUsing(function ($state, $record)
                    {
                        $subtotal = self::formatMoney(
                            $record->subtotal
                        );

                        $discountPercentage = number_format(
                            (float) $record->discount_percentage,
                            2,
                            ',',
                            '.'
                        );

                        $discountAmount = self::formatMoney(
                            $record->discount_amount
                        );

                        $dppAmount = self::formatMoney(
                            $record->dpp_amount
                        );

                        $ppnPercentage = number_format(
                            (float) $record->ppn_percentage,
                            2,
                            ',',
                            '.'
                        );

                        $ppnAmount = self::formatMoney(
                            $record->ppn_amount
                        );

                        $pphPercentage = number_format(
                            (float) $record->pph_percentage,
                            2,
                            ',',
                            '.'
                        );

                        $pphAmount = self::formatMoney(
                            $record->pph_amount
                        );

                        return new HtmlString("
                        <div style='line-height:1.5'>

                            <div>
                                <span style='
                                    font-size:12px;
                                    color:#6b7280;
                                '>
                                    Subtotal
                                </span>

                                <span style='
                                    font-weight:600;
                                    margin-left:8px;
                                '>
                                    {$subtotal}
                                </span>
                            </div>

                            <div>
                                <span style='
                                    font-size:12px;
                                    color:#6b7280;
                                '>
                                    Diskon
                                </span>

                                <span style='
                                    font-weight:600;
                                    margin-left:8px;
                                '>
                                    {$discountPercentage}%
                                    <span style='
                                        color:#6b7280;
                                        font-weight:400;
                                    '>
                                        ({$discountAmount})
                                    </span>
                                </span>
                            </div>

                            <div>
                                <span style='
                                    font-size:12px;
                                    color:#6b7280;
                                '>
                                    DPP
                                </span>

                                <span style='
                                    font-weight:600;
                                    margin-left:8px;
                                '>
                                    {$dppAmount}
                                </span>
                            </div>

                            <div>
                                <span style='
                                    font-size:12px;
                                    color:#6b7280;
                                '>
                                    PPN
                                </span>

                                <span style='
                                    font-weight:600;
                                    margin-left:8px;
                                '>
                                    {$ppnPercentage}%
                                    <span style='
                                        color:#6b7280;
                                        font-weight:400;
                                    '>
                                        ({$ppnAmount})
                                    </span>
                                </span>
                            </div>

                            <div>
                                <span style='
                                    font-size:12px;
                                    color:#6b7280;
                                '>
                                    PPh
                                </span>

                                <span style='
                                    font-weight:600;
                                    margin-left:8px;
                                '>
                                    {$pphPercentage}%
                                    <span style='
                                        color:#6b7280;
                                        font-weight:400;
                                    '>
                                        ({$pphAmount})
                                    </span>
                                </span>
                            </div>

                        </div>
                    ");
                    }),

                /*
             * TOTAL
             */
                /*
 * TOTAL
 * Total Amount + Net Amount
 */
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->html()
                    ->sortable()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder
                        {
                            return $query->where(function ($q) use ($search)
                            {
                                $q->where('total_amount', 'like', "%{$search}%")
                                    ->orWhere('net_amount', 'like', "%{$search}%");
                            });
                        }
                    )
                    ->alignEnd()
                    ->formatStateUsing(function ($state, $record)
                    {
                        $totalAmount = self::formatMoney(
                            $record->total_amount
                        );

                        $netAmount = self::formatMoney(
                            $record->net_amount
                        );

                        return new HtmlString("
                        <div style='
                            line-height:1.45;
                            text-align:right;
                        '>

                            <div style='
                                font-size:11px;
                                color:#6b7280;
                            '>
                                TOTAL TAGIHAN
                            </div>

                            <div style='
                                font-weight:700;
                                font-size:15px;
                                color:#111827;
                                white-space:nowrap;
                            '>
                                {$totalAmount}
                            </div>

                            <div style='
                                font-size:11px;
                                color:#6b7280;
                                margin-top:5px;
                            '>
                                NET AMOUNT
                            </div>

                            <div style='
                                font-weight:700;
                                font-size:14px;
                                color:#10B981;
                                white-space:nowrap;
                            '>
                                {$netAmount}
                            </div>

                        </div>
                    ");
                    }),
                /*
             * AUDIT
             */
                /*
 * AUDIT
 */
                TextColumn::make('created_by')
                    ->label('Audit')
                    ->html()
                    ->searchable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    )
                    ->formatStateUsing(function ($state, $record)
                    {
                        $createdAt = $record->created_at
                            ? $record->created_at->format('d M Y H:i')
                            : '-';

                        $updatedAt = $record->updated_at
                            ? $record->updated_at->format('d M Y H:i')
                            : '-';

                        return new HtmlString("
            <div style='line-height:1.45;'>

                <div style='font-weight:600;'>
                    " . e($record->created_by ?? '-') . "
                </div>

                <div style='
                    font-size:12px;
                    color:#6b7280;
                '>
                    Dibuat · {$createdAt}
                </div>

                <div style='
                    font-weight:600;
                    margin-top:6px;
                '>
                    " . e($record->updated_by ?? '-') . "
                </div>

                <div style='
                    font-size:12px;
                    color:#6b7280;
                '>
                    Diubah · {$updatedAt}
                </div>

            </div>
        ");
                    }),
            ])
            ->filters([
                SelectFilter::make('lab_job_id')
                    ->label('Lab Job')
                    ->relationship('labJob', 'code')
                    ->searchable()
                    ->preload(),

            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Format nominal Rupiah.
     */
    protected static function formatMoney(mixed $value): string
    {
        return 'Rp ' . number_format((float) ($value ?? 0), 2, ',', '.');
    }
}
