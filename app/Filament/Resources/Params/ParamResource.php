<?php

namespace App\Filament\Resources\Params;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Resources\Params\Pages\ManageParams;
use App\Models\Param;
use BackedEnum;
use Dompdf\FrameDecorator\Text;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ParamResource extends Resource
{
    protected static ?string $cluster = MasterCluster::class;
    protected static ?string $model = Param::class;
    protected static ?string $navigationLabel = 'Kode Parameter';
    protected static ?string $label = 'Kode Parameter';
    protected static string | \UnitEnum | null $navigationGroup = 'Parameter';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedBeaker;
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Kode Parameter')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20)
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->columns([
                TextColumn::make('code')
                    ->sortable()
                    ->label('Kode Parameter')
                    ->searchable(),
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
                ViewAction::make(),
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
            'index' => ManageParams::route('/'),
        ];
    }
}
