<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationLabel = 'Penawaran';
    protected static ?string $label = 'Penawaran';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('request_id')
                    ->label('Permohonan')
                    ->relationship('request', 'request_number')
                    ->helperText('Kosongkan jika bukan dari permohonan'),
                Select::make('customer.name')
                    ->label('Pelanggan')
                    ->required()
                    ->relationship('customer', 'name'),
                Hidden::make('personnel_id')
                    ->required()
                    ->default(Auth::user()->id),
                Forms\Components\TextInput::make('quotation_number')
                    ->label('Nomor penawaran')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('quotation_name')
                    ->label('Judul penawaran')
                    ->required()
                    ->maxLength(50),
                Forms\Components\DatePicker::make('quotation_date')
                    ->label('Tanggal penawaran')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('discount_percentage')
                    ->label('Diskon (persentase)')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('ppn_percentage')
                    ->label('Ppn')
                    ->required()
                    ->numeric()
                    ->default(11),
                Forms\Components\TextInput::make('pph_percentage')
                    ->label('Pph')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('total_amount')
                    ->label('Jumlah total')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('payment_terms')
                    ->label('Kebijakan pembayaran')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('quotation_status')
                    ->label('Status penawaran')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('request.code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('personnel.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation_name')
                    ->label('Judul penawaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quotation_number')
                    ->label('Kode penawaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quotation_date')
                    ->label('Tanggal penawaran')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ppn_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pph_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotation_status'),
                Tables\Columns\TextColumn::make('approved_by_user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime()
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
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'view' => Pages\ViewQuotation::route('/{record}'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}
