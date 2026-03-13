<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Master\MasterCluster;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ParameterResource\Pages\ManageParameters;
use App\Models\Enums\ParameterStatusEnum;
use App\Models\Parameter;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TagsInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ParameterResource extends Resource
{
    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $model = Parameter::class;
    protected static ?string $navigationLabel = 'Parameter Uji';
    protected static ?string $label = 'Parameter Uji';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::OutlinedBeaker;
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 2,
                'xl' => 2,
            ])
            ->components([
                // Section::make([
                TextInput::make('code')
                    ->required()
                    ->label('Kode parameter')
                    ->autocomplete(false)
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                TextInput::make('long_name')
                    ->required()
                    ->label('Nama Lengkap parameter')
                    ->autocomplete(false)
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('unit')
                    ->required()
                    ->label('Satuan')
                    ->autocomplete(false)
                    ->maxLength(50)
                    ->belowContent(
                        Schema::end([
                            Action::make('open_char_modal')
                                ->label('Spesial karakter')
                                ->modalHeading('Pilih Karakter Khusus')
                                ->modalSubmitActionLabel('Tutup')
                                ->modalCancelActionLabel('Batal')
                                ->link()
                                ->modalWidth('4xl')
                                ->modalContent(
                                    fn() => new HtmlString('<div style="width: 100%; height: 600px; overflow: hidden; border-radius: 8px;">
                                        <iframe src="https://copychar.cc/" style="width: 100%; height: 100%; border: none;"></iframe>
                                    </div>')
                                ),
                        ])
                    ),

                TextInput::make('default_price')
                    ->label('Harga standar')
                    ->required()
                    ->numeric()
                    ->label('Harga')
                    ->prefix('Rp. '),
                Select::make('test_method_id')
                    ->label('Metode uji')
                    ->relationship('testMethod', 'name')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('code')
                            ->label('Kode')
                            ->required(),
                        TextInput::make('name')
                            ->label('Nama metode uji')
                            ->required(),
                        Textarea::make('description')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])->createOptionModalHeading('Buat Metode uji'),
                TextInput::make('tested_time')
                    ->label('Waktu pengujian (menit)')
                    ->numeric(),
                TextInput::make('standard_notes')
                    ->placeholder('Baku Mutu Boleh Lebih dari Satu')
                    ->label('Baku Mutu (BML)'),
                Radio::make('status')
                    ->inline()
                    ->options(ParameterStatusEnum::labels())
                    ->default(ParameterStatusEnum::default())
                    ->required(),
                Textarea::make('description')
                    ->label('Keterangan')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('code', 'asc')
            ->groups([
                Group::make('unit')->label('Satuan')
            ])
            ->columns([
                TextColumn::make('code')
                    ->label('Kode parameter')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('long_name')
                    ->label('Nama parameter uji')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('default_price')
                    ->label('Harga')
                    ->alignEnd()
                    ->searchable()
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('testMethod.name')
                    ->label('Metode uji')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn($state) => ParameterStatusEnum::color($state))
                    ->formatStateUsing(fn($state) => ParameterStatusEnum::labels()[$state]),
                TextColumn::make('tested_time')
                    ->label('Waktu Pengujian')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('standard_notes')
                    ->searchable()
                    ->label('Baku Mutu (BML)'),
                TextColumn::make('created_by')
                    ->searchable(),
                TextColumn::make('updated_by')
                    ->searchable(),
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
                SelectFilter::make('test_method_id')
                    ->label('Metode Uji')
                    ->relationship('testMethod', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->columnSpan(2),

                Filter::make('default_price_range')
                    ->label('Range Harga')
                    ->schema([
                        TextInput::make('price_from')
                            ->label('Harga Minimum')
                            ->numeric()
                            ->prefix('Rp'),

                        TextInput::make('price_to')
                            ->label('Harga Maksimum')
                            ->numeric()
                            ->prefix('Rp'),
                    ])
                    ->columns(2)
                    ->columnSpan(3)
                    ->query(function (Builder $query, array $data) {
                        $query
                            ->when(
                                filled($data['price_from']),
                                fn($q) => $q->where('default_price', '>=', $data['price_from'])
                            )
                            ->when(
                                filled($data['price_to']),
                                fn($q) => $q->where('default_price', '<=', $data['price_to'])
                            );
                    }),

                Filter::make('initial')
                    ->label('Inisial')
                    ->schema([
                        Radio::make('inisial')
                            ->options(
                                ['' => 'Semua'] + collect(range('A', 'Z'))
                                    ->mapWithKeys(fn($l) => [$l => $l])
                                    ->toArray()
                            )
                            ->inline()
                            ->default('')
                            ->inlineLabel(false),
                    ])
                    ->columnSpanFull()
                    ->query(function (Builder $query, array $data) {
                        if (! filled($data['inisial'])) {
                            return;
                        }

                        $query->where('code', 'like', $data['inisial'] . '%');
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make()->slideOver(),
                DeleteAction::make()->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageParameters::route('/'),
        ];
    }
}
