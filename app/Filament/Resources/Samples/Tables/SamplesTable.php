<?php

namespace App\Filament\Resources\Samples\Tables;

use App\Models\Enums\SampleStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class SamplesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('labJobItem.description')
                    ->label(''),
            ])
            ->defaultGroup('labJobItem.description')
            ->columns([
                TextColumn::make('sample_code')
                    ->label('Kode Sampel')
                    ->searchable(),
                TextColumn::make('collectedByPersonel.fullname')
                    ->label('Ppc')
                    ->sortable(),
                TextColumn::make('receivedByPersonel.fullname')
                    ->label('Penerima')
                    ->sortable(),
                TextColumn::make('collection_date')
                    ->label('Tanggal Pengambilan')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('collection_time')
                    ->label('Waktu Pengambilan')
                    ->alignEnd()
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('latitude')
                    ->searchable(),
                TextColumn::make('longitude')
                    ->searchable(),
                TextColumn::make('container_type')
                    ->label('Jenis Wadah')
                    ->searchable(),
                TextColumn::make('container_quantity')
                    ->label('Jumlah Wadah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sample_volume')
                    ->label('Volume Sampel')
                    ->searchable(),
                TextColumn::make('preservation_method')
                    ->label('Metode Preservasi')
                    ->searchable(),
                TextColumn::make('received_date')
                    ->label('Tanggal Penerimaan')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('received_time')
                    ->label('Waktu Penerimaan')
                    ->alignEnd()
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => SampleStatusEnum::labels()[$state]),
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
