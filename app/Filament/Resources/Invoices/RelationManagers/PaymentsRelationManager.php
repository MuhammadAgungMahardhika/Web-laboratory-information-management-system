<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use App\Filament\Resources\Invoices\Actions\PaymentStatusAction;
use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Enums\PaymentStatusEnum;
use App\Services\PaymentService;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\HtmlString;

class PaymentsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;
    protected static string $relationship = 'payments';
    protected static ?string $label = 'Pembayaran';
    protected static ?string $title = 'Riwayat Pembayaran';

    public function form(Schema $schema): Schema
    {
        $paymentService = app(PaymentService::class);
        $ownerRecord = $this->ownerRecord;
        $alreadyPaid = $ownerRecord->payments()
            ->where('status', PaymentStatusEnum::Completed->value)
            ->sum('amount_paid');
        $remainingAmount = max(
            0,
            ($ownerRecord->net_amount ?? 0) - $alreadyPaid
        );
        return $schema
            ->components([
                TextEntry::make('invoice_code')
                    ->label('Kode Invoice')
                    ->color('primary')
                    ->state(fn() => $ownerRecord->code),
                TextEntry::make('invoice_total')
                    ->label('Total Tagihan')
                    ->state(fn() =>  $ownerRecord->net_amount)
                    ->copyable()
                    ->color('primary')
                    ->formatStateUsing(
                        fn($state) => 'Rp ' . number_format($state, 0, ',', '.')
                    )
                    ->disabled(),
                TextInput::make('code')
                    ->label('Kode Pembayaran')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(fn() => $paymentService->generatePaymentCode())
                    ->maxLength(50)
                    ->readOnly(),


                DatePicker::make('date')
                    ->label('Tanggal Pembayaran')
                    ->required()
                    ->default(now())
                    ->native(false),

                TextInput::make('amount_paid')
                    ->label('Jumlah Dibayar')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0)
                    ->inputMode('decimal')
                    ->aboveContent([
                        Action::make('dp20')
                            ->label('20%')
                            ->disabled(fn() => 'view' === $this->getMountedAction()?->getName())
                            ->icon(Heroicon::OutlinedCalculator)
                            ->color('gray')
                            ->action(function ($set) use ($remainingAmount)
                            {
                                $set(
                                    'amount_paid',
                                    round($remainingAmount * 0.20)
                                );
                                $set('notes', 'Pembayaran 20% dari total tagihan');
                            }),

                        Action::make('dp40')
                            ->label('40%')
                            ->disabled(fn() => 'view' === $this->getMountedAction()?->getName())
                            ->icon(Heroicon::OutlinedCalculator)
                            ->color('warning')
                            ->action(function ($set) use ($remainingAmount)
                            {
                                $set(
                                    'amount_paid',
                                    round($remainingAmount * 0.40)
                                );
                                $set('notes', 'Pembayaran 40% dari total tagihan');
                            }),

                        Action::make('full')
                            ->label('100%')
                            ->disabled(fn() => 'view' === $this->getMountedAction()?->getName())
                            ->icon(Heroicon::OutlinedCheckCircle)
                            ->color('success')
                            ->action(function ($set) use ($remainingAmount)
                            {
                                $set(
                                    'amount_paid',
                                    round($remainingAmount)
                                );
                                $set('notes', 'Pelunasan tagihan');
                            }),
                    ])
                    ->belowContent([
                        TextEntry::make('amount_paid_formatted')
                            ->label('Total Tagihan')
                            ->state(fn() => $ownerRecord->net_amount !== null ? 'Rp ' . number_format($ownerRecord->net_amount, 0, ',', '.') : '')
                            ->copyAbleState(fn() => $ownerRecord->net_amount !== null ? $ownerRecord->net_amount : 0)
                            ->disabled(),
                        TextEntry::make('already_paid')
                            ->label('Total Sudah Dibayar')
                            ->state(fn() => $alreadyPaid  !== null ? 'Rp ' . number_format($alreadyPaid, 0, ',', '.') : '')
                            ->copyAbleState(fn() => $alreadyPaid !== null ? $alreadyPaid : 0)
                            ->disabled(),
                        TextEntry::make('remaining_amount')
                            ->label('Sisa Tagihan')
                            ->state(fn() => $ownerRecord->net_amount !== null ? 'Rp ' . number_format($ownerRecord->net_amount - $alreadyPaid, 0, ',', '.') : '')
                            ->disabled()
                            ->copyable()
                            ->copyAbleState(fn() => $ownerRecord->net_amount !== null ? $ownerRecord->net_amount - $alreadyPaid  : 0),
                    ]),


                TextInput::make('reference_number')
                    ->label('Nomor Referensi')
                    ->placeholder('Contoh: Nomor transaksi / nomor bukti transfer')
                    ->maxLength(255),


                FileUpload::make('attachment_path')
                    ->label('Bukti Pembayaran')
                    ->disk('public')
                    ->directory('payments')
                    ->visibility('private')
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'application/pdf',
                    ])

                    ->maxSize(5120)
                    ->downloadable()
                    ->openable(),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->placeholder('Tambahkan catatan pembayaran jika diperlukan...')
                    ->rows(3),
                Radio::make('payment_method')
                    ->inline()
                    ->label('Metode Pembayaran')
                    ->required()
                    ->options([
                        'cash' => 'Tunai',
                        'qris' => 'QRIS',
                        'transfer' => 'Transfer Bank',
                        'other' => 'Lainnya',
                    ]),
                TextEntry::make('status')
                    ->label('Status Pembayaran')
                    ->visible(fn($record) => $record?->status !== null)
                    ->formatStateUsing(
                        fn(int $state): string =>
                        PaymentStatusEnum::from($state)->label()
                    )
                    ->badge()
                    ->color(
                        fn(int $state): string =>
                        PaymentStatusEnum::color($state)
                    ),

                Hidden::make('status')
                    ->default(fn($record) => $record?->status ?? PaymentStatusEnum::Pending->value)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->columns([
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(
                        fn(int $state): string =>
                        PaymentStatusEnum::from($state)->label()
                    )
                    ->badge()
                    ->color(
                        fn(int $state): string =>
                        PaymentStatusEnum::color($state)
                    ),
                TextColumn::make('payment_codes')
                    ->label('Kode')
                    ->state(fn($record) => $record)
                    ->formatStateUsing(function ($record): HtmlString
                    {
                        $html = '<div style="
                            display: flex;
                            flex-direction: column;
                            gap: 3px;
                            white-space: nowrap;
                        ">';

                        $html .= sprintf(
                            '<div style="line-height: 1.4;">
                                <span style="color: #6b7280;">Kode :</span> %s
                            </div>',
                            e($record->code)
                        );
                        if ($record->reference_number)
                        {
                            $html .= sprintf(
                                '<div style="
                                    line-height: 1.4;
                                    color: #6b7280;
                                    font-size: 0.875rem;
                                ">
                                    <span>Nomor Referensi :</span> %s
                                </div>',
                                e($record->reference_number)
                            );
                        }
                        if ($record->receipt_number)
                        {
                            $html .= sprintf(
                                '<div style="
                                    line-height: 1.4;
                                    color: #6b7280;
                                    font-size: 0.875rem;
                                ">
                                    <span>Kuitansi :</span> %s
                                </div>',
                                e($record->receipt_number)
                            );
                        }

                        $html .= '</div>';

                        return new HtmlString($html);
                    })
                    ->html()
                    ->wrap(false)
                    ->searchable(query: function (Builder $query, string $search): Builder
                    {
                        return $query->where(function (Builder $query) use ($search)
                        {
                            $query
                                ->where('code', 'like', "%{$search}%")
                                ->orWhere('reference_number', 'like', "%{$search}%")
                                ->orWhere('receipt_number', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('payment_details')
                    ->label('Pembayaran')
                    ->state(fn($record) => $record)
                    ->formatStateUsing(function ($record): HtmlString
                    {
                        $paymentMethod = match ($record->payment_method)
                        {
                            'cash' => 'Tunai',
                            'qris' => 'QRIS',
                            'transfer' => 'Transfer Bank',
                            'other' => 'Lainnya',
                            default => '-',
                        };

                        $amount = 'Rp ' . number_format(
                            $record->amount_paid,
                            0,
                            ',',
                            '.'
                        );

                        // Maksimal 40 karakter
                        $notes = $record->notes
                            ? trim($record->notes)
                            : null;

                        $shortNotes = $notes
                            ? \Illuminate\Support\Str::limit($notes, 40)
                            : null;

                        $notesHtml = $shortNotes
                            ? sprintf(
                                '<div
                    style="
                        line-height: 1.4;
                        color: #6b7280;
                        font-size: 0.75rem;
                        max-width: 250px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    "
                    title="%s"
                >
                    %s
                </div>',
                                e($notes),
                                e($shortNotes)
                            )
                            : '';

                        $html = sprintf(
                            '<div style="
                display: flex;
                flex-direction: column;
                gap: 3px;
                white-space: nowrap;
            ">
                <div style="line-height: 1.4;">
                    %s
                </div>

                <div style="
                    line-height: 1.4;
                    color: #10B981;
                    font-weight: 600;
                    font-size: 1rem;
                ">
                    %s
                </div>

                    %s
                </div>',
                            e($paymentMethod),
                            e($amount),
                            $notesHtml,
                        );

                        return new HtmlString($html);
                    })
                    ->html()
                    ->wrap(false)
                    ->sortable(),
                TextColumn::make('record_information')
                    ->label('Audit')
                    ->state(fn($record) => $record)
                    ->formatStateUsing(function ($record): HtmlString
                    {
                        $createdAt = $record->created_at
                            ? $record->created_at->format('d M Y H:i')
                            : '-';

                        $createdBy = $record->created_by ?: '-';

                        $html = sprintf(
                            '<div style="
                display: flex;
                flex-direction: column;
                gap: 3px;
                white-space: nowrap;
            ">
                <div style="
                    line-height: 1.4;
                    color: #6b7280;
                    font-size: 0.875rem;
                ">
                    <span>Oleh :</span> %s
                </div>

                <div style="
                    line-height: 1.4;
                    color: #9ca3af;
                    font-size: 0.75rem;
                ">
                    <span>Dicatat :</span> %s
                </div>
            </div>',
                            e($createdBy),
                            e($createdAt),
                        );

                        return new HtmlString($html);
                    })
                    ->html()
                    ->wrap(false)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pembayaran')
                    ->icon(Heroicon::OutlinedPlus),
            ])
            ->recordActions([
                PaymentStatusAction::preview(),
                ViewAction::make()
                    ->label('Lihat')
                    ->icon(Heroicon::OutlinedEye)
                    ->authorize(fn($record) => in_array($record?->status, [PaymentStatusEnum::Completed->value, PaymentStatusEnum::Cancelled->value]))
                    ->extraModalFooterActions(
                        collect(PaymentStatusEnum::cases())
                            ->map(
                                fn(PaymentStatusEnum $status) =>
                                Action::make('setStatus_' . $status->value)
                                    ->label($status->label())
                                    ->color(PaymentStatusEnum::color($status->value))
                                    ->icon(Heroicon::OutlinedCheckCircle)
                                    ->visible(
                                        fn($record) =>
                                        $record?->status !== $status->value
                                    )
                                    ->requiresConfirmation()
                                    ->modalHeading('Ubah Status Pembayaran')
                                    ->modalDescription(
                                        fn($record) =>
                                        "Ubah status pembayaran \"{$record?->code}\" "
                                            . "menjadi \"{$status->label()}\"?"
                                    )
                                    ->action(function ($record, $livewire) use ($status)
                                    {
                                        try
                                        {
                                            app(PaymentService::class)
                                                ->updateStatus($record, $status);

                                            Notification::make()
                                                ->title('Status pembayaran berhasil diubah')
                                                ->success()
                                                ->send();
                                            // Tutup action status
                                            $livewire->unmountAction();

                                            // Tutup ViewAction parent
                                            $livewire->unmountAction('view');
                                        }
                                        catch (\Throwable $e)
                                        {
                                            Notification::make()
                                                ->title('Gagal mengubah status')
                                                ->body($e->getMessage())
                                                ->danger()
                                                ->send();
                                        }
                                    })
                                    ->after(
                                        function (): void
                                        {
                                            $this->dispatch(
                                                'invoice-updated'
                                            );
                                        }
                                    )
                            )
                            ->all()
                    ),
                EditAction::make()
                    ->label('Ubah')
                    ->authorize(
                        fn($record) =>
                        $record?->receipt_number === null || $record?->status === PaymentStatusEnum::Pending->value
                    )->extraModalFooterActions(
                        collect(PaymentStatusEnum::cases())
                            ->map(
                                fn(PaymentStatusEnum $status) =>
                                Action::make('setStatus_' . $status->value)
                                    ->label($status->label())
                                    ->color(PaymentStatusEnum::color($status->value))
                                    ->icon(Heroicon::OutlinedCheckCircle)
                                    ->visible(
                                        fn($record) =>
                                        $record?->status !== $status->value
                                    )
                                    ->requiresConfirmation()
                                    ->modalHeading('Ubah Status Pembayaran')
                                    ->modalDescription(
                                        fn($record) =>
                                        "Ubah status pembayaran \"{$record?->code}\" "
                                            . "menjadi \"{$status->label()}\"?"
                                    )
                                    ->action(function ($record, $livewire) use ($status)
                                    {
                                        try
                                        {
                                            app(PaymentService::class)
                                                ->updateStatus($record, $status);

                                            Notification::make()
                                                ->title('Status pembayaran berhasil diubah')
                                                ->success()
                                                ->send();
                                            // Tutup action status
                                            $livewire->unmountAction();

                                            // Tutup ViewAction parent
                                            $livewire->unmountAction('view');
                                        }
                                        catch (\Throwable $e)
                                        {
                                            Notification::make()
                                                ->title('Gagal mengubah status')
                                                ->body($e->getMessage())
                                                ->danger()
                                                ->send();
                                        }
                                    })->after(
                                        function (): void
                                        {
                                            $this->dispatch(
                                                'invoice-updated'
                                            );
                                        }
                                    )
                            )
                            ->all()
                    )->after(
                        function (): void
                        {
                            $this->dispatch(
                                'invoice-updated'
                            );
                        }
                    ),
                DeleteAction::make()
                    ->label('Hapus')
                    ->authorize(fn($record) => $record?->status !== PaymentStatusEnum::Completed->value)
                    ->after(
                        function (): void
                        {
                            $this->dispatch(
                                'invoice-updated'
                            );
                        }
                    ),
            ])
            ->toolbarActions([]);
    }
}
