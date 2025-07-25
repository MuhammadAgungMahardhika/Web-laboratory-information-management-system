<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestPackageResource\Pages;
use App\Filament\Resources\TestPackageResource\RelationManagers;
use App\Models\Enums\EnvironmentTypeEnum;
use App\Models\Enums\ParameterStatusEnum;
use App\Models\TestPackage;
use App\Traits\HasAuthorization;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestPackageResource extends Resource
{
    use HasAuthorization;
    protected static ?string $model = TestPackage::class;
    protected static ?string $navigationLabel = 'Paket Pengujian';
    protected static ?string $label = 'Paket Pengujian';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama paket pengujian')
                    ->required(),
                Forms\Components\Select::make('sample_matric_id')
                    ->label('Matrix sampel')
                    ->required()
                    ->relationship('sampleMatric', 'name')
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\Select::make('sample_type_id')
                            ->label('Jenis sampel')
                            ->required()
                            ->relationship('sampleType', 'name')
                            ->preload(),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('environment_type')
                            ->label('Jenis lingkungan')
                            ->options(EnvironmentTypeEnum::labels())
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])
                    ->createOptionModalHeading('Buat Matrix Sampel')
                    ->preload(),
                Forms\Components\Select::make('regulation_id')
                    ->label('Regulasi')
                    ->required()
                    ->relationship('regulation', 'name')
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                    ])->createOptionModalHeading('Buat Regulasi')
                    ->preload(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif ?')
                    ->default(true)
                    ->required(),
                Forms\Components\Select::make('parameters')
                    ->label('Parameter')
                    ->multiple()
                    ->relationship('parameters', 'name')
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        // Ambil ID parameter yang dipilih
                        $parameterIds = $state;
                        // Ambil total harga dari parameter
                        $totalParameterPrice = \App\Models\Parameter::whereIn('id', $parameterIds)->sum('default_price');
                        // Set harga baru = harga awal + total harga dari parameter
                        $set('price', $totalParameterPrice);
                    })
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nama parameter uji')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('unit')
                            ->required()
                            ->label('Satuan')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('default_price')
                            ->required()
                            ->label('Harga standar')
                            ->numeric(),
                        Forms\Components\Select::make('test_method_id')
                            ->label('Metode uji')
                            ->relationship('testMethod', 'name')
                            ->searchable()
                            ->required()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('code')
                                    ->label('Kode')
                                    ->required(),
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama metode uji')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Keterangan')
                                    ->columnSpanFull(),
                            ])->createOptionModalHeading('Buat Metode uji'),
                        Forms\Components\Textarea::make('description')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->options(ParameterStatusEnum::labels())
                            ->default(ParameterStatusEnum::default())
                            ->required(),
                    ])
                    ->required()
                    ->preload(),
                Forms\Components\Textarea::make('description')
                    ->label('Keterangan'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Harga')
                    ->prefix('Rp. '),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama paket pengujian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sampleMatric.name')
                    ->label('Matrix sampel')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('regulation.name')
                    ->label('Regulasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('parameters.name')
                    ->label('Parameter')
                    ->listWithLineBreaks()
                    ->searchable()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestPackages::route('/'),
            'create' => Pages\CreateTestPackage::route('/create'),
            'view' => Pages\ViewTestPackage::route('/{record}'),
            'edit' => Pages\EditTestPackage::route('/{record}/edit'),
        ];
    }
}
