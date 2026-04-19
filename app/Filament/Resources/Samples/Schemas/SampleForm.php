<?php

namespace App\Filament\Resources\Samples\Schemas;

use App\Models\Enums\SampleCollectionTypeEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJobItem;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class SampleForm
{
    public const PERMISSION_COLLECTING_SAMPLE = 'collecting-sample';
    public const PERMISSION_RECEIVING_SAMPLE = 'receiving-sample';

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }
    public static function configure(Schema $schema): Schema
    {
        $personel = Auth::user()->personel;
        return  $schema
            ->components([
                Section::make([
                    Select::make('lab_job_item_id')
                        ->label('Produk Uji')
                        ->relationship('labJobItem', 'description', modifyQueryUsing: function ($query) {
                            return $query
                                ->where('group', 'A');
                        })
                        ->required()
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function ($state,  $set) {
                            if ($state) {
                                // Inisialisasi service
                                $sampleService = new \App\Services\SampleService();
                                $labJobItem = LabJobItem::find($state);
                                $sampleCode = $sampleService->generateSampleCode($labJobItem);
                                $set('sample_code', $sampleCode);
                            } else {
                                $set('sample_code', null);
                            }
                        }),
                    TextInput::make('sample_code')
                        ->label('Kode Sampel')
                        ->unique()
                        ->live()
                        ->disabled()
                        ->dehydrated()
                        ->required(),
                    Select::make('status')
                        ->label('Status')
                        ->options(function ($record) {
                            $baseOptions = [
                                SampleStatusEnum::Received->value => SampleStatusEnum::Received->label(),
                                SampleStatusEnum::Invalid->value => SampleStatusEnum::Invalid->label(),
                            ];
                            // Jika edit dan record punya status lain, tambahkan status tersebut ke options
                            if ($record && !array_key_exists($record->status, $baseOptions)) {
                                $allLabels = SampleStatusEnum::labels();
                                $baseOptions[$record->status] = $allLabels[$record->status];
                            }
                            return $baseOptions;
                        })
                        ->default(SampleStatusEnum::default())
                        ->required(),
                    Radio::make('collection_type')
                        ->label('Keterangan Lain')
                        ->options(SampleCollectionTypeEnum::labels())
                        ->live()
                        ->default(SampleCollectionTypeEnum::default()->value)
                        ->inline(),
                ])->columnSpanFull()->visible(fn() => static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE))->columns(4),
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('pengambilan')
                            ->label('PENGAMBILAN SAMPEL OLEH PPC')
                            ->columnSpanFull()

                            ->icon(Heroicon::OutlinedBeaker)
                            ->schema([
                                Select::make('collected_by_personel_id')
                                    ->relationship(
                                        'collectedByPersonel',
                                        'fullname',
                                    )
                                    ->label('Ppc')
                                    ->searchable()
                                    ->preload(),
                                DatePicker::make('collection_date')
                                    ->label('Tanggal Pengambilan')
                                    ->default(now()),
                                TimePicker::make('collection_time')
                                    ->label('Waktu Pengambilan')
                                    ->default(now()->format('H:i:s')),

                                TextInput::make('preservation_method')
                                    ->label('Metode Preservasi')
                                    ->maxLength(255),
                                Textarea::make('collection_notes')
                                    ->label('Catatan Pengambilan')
                                    ->columnSpan(2),
                                Section::make('Lokasi pengambilan')
                                    ->columns(1)
                                    ->columnSpan(2)
                                    ->schema([
                                        Textarea::make('collection_location_desc')
                                            ->label('Lokasi Pengambilan'),
                                        TextInput::make('latitude'),
                                        TextInput::make('longitude'),
                                    ])->inlineLabel(),

                            ])->columns(4)->visible(
                                fn(Get $get) => static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE)
                                    && SampleCollectionTypeEnum::tryFrom($get('collection_type')) === SampleCollectionTypeEnum::Collected
                            ),
                        Tab::make('penerimaan')
                            ->label('PENERIMAAN SAMPEL OLEH ADMIN')
                            ->icon(Heroicon::OutlinedInbox)
                            ->columnSpanFull()
                            ->schema([
                                Select::make('received_by_personel_id')
                                    ->relationship('receivedByPersonel', 'fullname')
                                    ->label('Penerima')
                                    ->default(static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE) ? ($personel->id ?? null) : null)
                                    ->searchable()
                                    ->preload(),
                                DatePicker::make('received_date')
                                    ->label('Tanggal Penerimaan')
                                    ->default(now())
                                    ->required(),
                                TimePicker::make('received_time')
                                    ->label('Waktu Penerimaan')
                                    ->default(now()->format('H:i:s'))
                                    ->required(),
                                Textarea::make('received_condition_notes')
                                    ->label('Catatan Kondisi Penerimaan')
                                    ->columnSpan(2),
                                Section::make('Wadah dan Volume')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('container_type')
                                            ->label('Jenis Wadah')
                                            ->maxLength(50)
                                            ->nullable(),
                                        TextInput::make('container_quantity')
                                            ->label('Jumlah Wadah')
                                            ->required()
                                            ->numeric()
                                            ->default(1),
                                        TextInput::make('sample_volume')
                                            ->label('Volume Sampel')
                                            ->maxLength(50)
                                            ->nullable(),
                                    ])->columnSpan(2)
                                    ->inlineLabel(),
                            ])->columns(4)->visible(fn() => static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE)),
                    ])
                    ->columnSpanFull()->visible(fn(Get $get) => !is_null($get('sample_code')))->activeTab(function (Get $get) {
                        return SampleCollectionTypeEnum::tryFrom($get('collection_type')) === SampleCollectionTypeEnum::Collected
                            ? 1 : 2;
                    }),
            ]);
    }
}
