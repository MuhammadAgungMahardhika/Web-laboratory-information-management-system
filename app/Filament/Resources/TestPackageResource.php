<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\TestPackageResource\Pages\ListTestPackages;
use App\Filament\Resources\TestPackageResource\Pages\CreateTestPackage;
use App\Filament\Resources\TestPackageResource\Pages\ViewTestPackage;
use App\Filament\Resources\TestPackageResource\Pages\EditTestPackage;
use App\Filament\Resources\TestPackageResource\RelationManagers\ParameterTestPackagesRelationManager;
use App\Models\Enums\EnvironmentTypeEnum;
use App\Models\TestPackage;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class TestPackageResource extends Resource
{
    protected static ?string $model = TestPackage::class;
    protected static ?string $navigationLabel = 'Produk Uji';
    protected static ?string $label = 'Produk Uji';
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::ArchiveBox;
    protected static ?int $navigationSort = 5;
    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('name')
                        ->label('Nama produk uji')
                        ->required(),
                    Select::make('sample_matric_code')
                        ->label('Matrix sampel')
                        ->required()
                        ->relationship('sampleMatric', 'code_name')
                        ->searchable()
                        ->createOptionForm([
                            TextInput::make('code')
                                ->label('Kode')
                                ->required()
                                ->maxLength(10),
                            Select::make('sample_type_id')
                                ->label('Jenis sampel')
                                ->required()
                                ->relationship('sampleType', 'name')
                                ->preload(),
                            TextInput::make('name')
                                ->label('Nama')
                                ->required()
                                ->maxLength(100),
                            Select::make('environment_type')
                                ->label('Jenis lingkungan')
                                ->options(EnvironmentTypeEnum::labels())
                                ->required(),
                            Textarea::make('description')
                                ->label('Keterangan')
                                ->columnSpanFull(),
                        ])
                        ->createOptionModalHeading('Buat Matrix Sampel')
                        ->preload(),
                    Select::make('regulation_id')
                        ->label('Regulasi/Standar')
                        ->searchable(['long_name', 'name'])
                        ->relationship('regulation', 'long_name')
                        ->preload(),

                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->label('Harga')
                        ->prefix('Rp. '),
                    Toggle::make('is_active')
                        ->label('Aktif ?')
                        ->default(true)
                        ->required(),
                    Textarea::make('description')
                        ->label('Keterangan'),

                ])->columns(1)->inlineLabel()->columnSpanFull()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('sampleMatric.name')->label('Matrix')->collapsible(),
                Group::make('regulation.name')->label('Regulasi')->collapsible(),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Produk Uji')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhereHas('sampleMatric', function (Builder $query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('regulation', function (Builder $query) use ($search) {
                                $query->where('long_name', 'like', "%{$search}%");
                            });
                    })
                    ->html()
                    ->size(TextSize::Small)
                    ->formatStateUsing(function ($state, $record) {
                        return new HtmlString("
            <div class='font-medium'>
                " . e(str($state)->limit(45)) . "
            </div>

            <div class='text-xs text-gray-500 mt-1'>
                <div>
                    <strong>Matrix:</strong>
                    " . e(str($record->sampleMatric?->name)->limit(30)) . "
                </div>

                <div>
                    <strong>Regulasi:</strong>
                    " . e(str($record->regulation?->long_name)->limit(40)) . "
                </div>
            </div>
        ");
                    })
                    ->extraAttributes([
                        'class' => 'max-w-lg',
                    ]),

                TextColumn::make('parameters.long_name_standard_notes')
                    ->label('Parameter')
                    ->limitList(5)
                    ->expandableLimitedList()
                    ->listWithLineBreaks()
                    ->searchable()
                    ->badge()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('idr')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif ?')
                    ->boolean(),
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
                SelectFilter::make('sample_matric_code')
                    ->label('Matrix')
                    ->relationship('sampleMatric', 'code_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('regulation_id')
                    ->label('Regulasi')
                    ->columnSpan(2)
                    ->relationship('regulation', 'long_name')
                    ->searchable(['name', 'long_name'])
                    ->preload(),
                SelectFilter::make('is_active')
                    ->label('Aktif ?')
                    ->options([
                        1 => 'Ya',
                        0 => 'Tidak',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ParameterTestPackagesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestPackages::route('/'),
            'create' => CreateTestPackage::route('/create'),
            'view' => ViewTestPackage::route('/{record}'),
            'edit' => EditTestPackage::route('/{record}/edit'),
        ];
    }
}
