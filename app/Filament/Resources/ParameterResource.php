<?php

namespace App\Filament\Resources;

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
use App\Filament\Resources\ParameterResource\Pages;
use App\Filament\Resources\ParameterResource\RelationManagers;
use App\Models\Enums\ParameterStatusEnum;
use App\Models\Parameter;
use App\Traits\HasAuthorization;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParameterResource extends Resource
{
    use HasAuthorization;
    protected static ?string $model = Parameter::class;
    protected static ?string $navigationLabel = 'Parameter Uji';
    protected static ?string $label = 'Parameter Uji';
    protected static string | \UnitEnum | null $navigationGroup = 'Master';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->components([
                Section::make([
                    Section::make([
                        TextInput::make('name')
                            ->required()
                            ->label('Nama parameter uji')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('unit')
                            ->required()
                            ->label('Satuan')
                            ->maxLength(50),
                        TextInput::make('default_price')
                            ->label('Harga standar')
                            ->required()
                            ->numeric()
                            ->step(10000)
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
                            ])->createOptionModalHeading('Buat Regulasi'),
                    ])->heading('Parameter uji')->columns(1)->inlineLabel(),
                    // Standar nilai
                    Section::make([
                        TextInput::make('standart_value')
                            ->required()
                            ->label('Nilai standar')
                            ->maxLength(100),
                        TextInput::make('standard_unit')
                            ->required()
                            ->label('Satuan standar')
                            ->maxLength(50),
                        Textarea::make('standard_notes')
                            ->required()
                            ->label('Catatan standar')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->heading('Standar Referensi')->columns(1)->inlineLabel(),
                ])->columnSpanFull()->columns(2),

                Textarea::make('description')
                    ->label('Keterangan')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(ParameterStatusEnum::labels())
                    ->default(ParameterStatusEnum::default())
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama parameter uji')
                    ->searchable(),
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->searchable(),
                TextColumn::make('default_price')
                    ->label('Harga standar')
                    ->alignEnd()
                    ->searchable()
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('testMethod.name')
                    ->label('Metode uji')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => ParameterStatusEnum::color($state))
                    ->formatStateUsing(fn($state) => ParameterStatusEnum::labels()[$state]),
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
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
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
