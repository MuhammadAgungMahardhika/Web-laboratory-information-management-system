<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\Enums\JobStatusEnum;
use App\Models\LabJob;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        $invoiceService = app(InvoiceService::class);
        return $schema
            ->columns([
                'default' => 1,
                'lg' => 2,
            ])
            ->components([
                Section::make('Informasi Tagihan')
                    ->components([
                        DatePicker::make('invoice_date')
                            ->label('Tanggal Tagihan')
                            ->required()
                            ->default(now())
                            ->live() // <-- 1. JADIKAN LIVE: Ini adalah pemicunya
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                // 2. AKSI: Jalankan ini setelah tanggal Tagihan diubah
                                if ($state) {
                                    // Ubah nilai 'due_date' menjadi 30 hari setelah tanggal baru
                                    $set('due_date', Carbon::parse($state)->addDays(30)->format('Y-m-d'));
                                }
                            }),

                        DatePicker::make('due_date')
                            ->label('Tanggal jatuh Tempo')
                            ->required()
                            ->helperText('Otomatis diatur ke 30 hari setelah Tanggal Tagihan')
                            ->default(now()->addDays(30)) // <-- Default awal tetap berguna
                            ->afterOrEqual('invoice_date'),
                        Select::make('lab_job_id')
                            ->label('Nomor Lab Job')
                            ->disabledOn(['view', 'edit'])
                            ->relationship('labJob', 'code', modifyQueryUsing: function ($query,  $record) {
                                $currentInvoiceId = $record?->id;
                                return $query->whereDoesntHave('invoice', function (Builder $q) use ($currentInvoiceId) {
                                    if ($currentInvoiceId) {
                                        // Saat EDIT, abaikan invoice yang sedang diedit (memungkinkan Lab Job muncul)
                                        $q->where('id', '!=', $currentInvoiceId);
                                    }
                                });
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live() // <-- Wajib untuk memicu update
                            ->afterStateUpdated(function ($state, Set $set) use ($invoiceService) {
                                if ($state) {
                                    $labJob = LabJob::find($state);
                                    $invoiceNumber = $invoiceService->generateInvoiceNumber($labJob);
                                    $set('invoice_number', $invoiceNumber);
                                } else {
                                    $set('invoice_number', null);
                                }
                            }),
                        Checkbox::make('manual_invoice_confirmation')
                            ->dehydrated(false)
                            ->live()
                            ->inline()
                            ->visibleOn('create')
                            ->label('Manual Input Nomor Tagihan'),
                        TextInput::make('invoice_number')
                            ->label('Nomor Tagihan')
                            ->required()
                            ->live()
                            ->unique(ignoreRecord: true)
                            ->readOnly(fn(Get $get) => !$get('manual_invoice_confirmation')),


                        TextInput::make('discount')
                            ->label('Diskon (%)')
                            ->required()
                            ->numeric()
                            ->default(0.0),

                        TextInput::make('tax_rate')
                            ->label('Pajak (%)')
                            ->required()
                            ->numeric()
                            ->default(0.0),

                        TextInput::make('total_amount')
                            ->label('Jumlah Total')
                            ->required()
                            ->numeric()
                            ->visible(fn($record) => $record?->total_amount),

                    ])->columns([
                        'default' => 1,
                        'lg' => 2,
                    ])->columnSpanFull(),
            ]);
    }
}
