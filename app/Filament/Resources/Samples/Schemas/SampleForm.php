<?php

namespace App\Filament\Resources\Samples\Schemas;

use App\Models\Enums\SampleCollectionTypeEnum;
use App\Models\Enums\SampleStatusEnum;
use App\Models\LabJobItem;
use App\Services\SampleService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
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
        $sampleService = app(SampleService::class);
        return  $schema
            ->components([
                Section::make([
                    Select::make('lab_job_item_id')
                        ->label('Produk Uji')
                        ->relationship('labJobItem', 'description_code', modifyQueryUsing: function ($query) {
                            return $query
                                ->where('group', 'A');
                        })
                        ->required()
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function ($state,  $set) use ($sampleService) {
                            if ($state) {
                                // Inisialisasi service
                                $labJobItem = LabJobItem::find($state);
                                $sampleCode = $sampleService->generateSampleCode($labJobItem);
                                $set('code', $sampleCode);
                            } else {
                                $set('code', null);
                            }
                        }),
                    TextInput::make('code')
                        ->label('Nomor Sampel')
                        ->unique()
                        ->live()
                        ->disabled()
                        ->dehydrated()

                        ->required(),
                    Select::make('status')
                        ->label('Status')
                        ->searchable()
                        ->disabled()
                        ->dehydrated()
                        ->options(SampleStatusEnum::labels())
                        ->default(SampleStatusEnum::default())
                        ->required(),
                    Radio::make('collection_type')
                        ->label('Keterangan Lain')
                        ->default(SampleCollectionTypeEnum::default())
                        ->options(SampleCollectionTypeEnum::labels())
                        ->live()
                        ->inline(),
                ])->columnSpanFull()->columns(1)->visible(fn() => static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE))->inlineLabel(),
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('pengambilan')
                            ->label('PENGAMBILAN SAMPEL')
                            ->columnSpanFull()
                            ->columns(2)
                            ->inlineLabel()
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
                                TextInput::make('latitude'),
                                TextInput::make('longitude'),

                                Textarea::make('collection_location_desc')
                                    ->label('Lokasi Pengambilan'),
                                Textarea::make('collection_notes')
                                    ->label('Catatan Pengambilan'),

                            ])->visible(
                                fn(Get $get) => static::isAuthorized(static::PERMISSION_COLLECTING_SAMPLE)
                                    && SampleCollectionTypeEnum::tryFrom($get('collection_type')) === SampleCollectionTypeEnum::Collected
                            ),
                        Tab::make('penerimaan')
                            ->label('PENERIMAAN SAMPEL')
                            ->icon(Heroicon::OutlinedInbox)
                            ->columnSpanFull()
                            ->columns(2)
                            ->inlineLabel()
                            ->schema([
                                Select::make('received_by_personel_id')
                                    ->relationship('receivedByPersonel', 'fullname')
                                    ->label('Penerima')
                                    ->default(static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE) ? ($personel->id ?? null) : null)
                                    ->searchable()
                                    ->preload(),
                                DatePicker::make('received_date')
                                    ->label('Tanggal Penerimaan')
                                    ->default(now()),
                                TimePicker::make('received_time')
                                    ->label('Waktu Penerimaan')
                                    ->default(now()->format('H:i:s')),
                                Textarea::make('received_condition_notes')
                                    ->label('Catatan Kondisi Penerimaan'),
                                TextInput::make('container_type')
                                    ->label('Jenis Wadah')
                                    ->maxLength(50)
                                    ->nullable(),
                                TextInput::make('container_quantity')
                                    ->label('Jumlah Wadah')

                                    ->numeric()
                                    ->default(1),
                                TextInput::make('sample_volume')
                                    ->label('Volume Sampel')
                                    ->maxLength(50)
                                    ->nullable(),
                            ])->visible(fn() => static::isAuthorized(static::PERMISSION_RECEIVING_SAMPLE)),
                    ])
                    ->columnSpanFull()->visible(fn(Get $get) => !is_null($get('code')))->activeTab(function (Get $get) {
                        return SampleCollectionTypeEnum::tryFrom($get('collection_type')) === SampleCollectionTypeEnum::Collected
                            ? 1 : 2;
                    }),
            ]);
    }
}
