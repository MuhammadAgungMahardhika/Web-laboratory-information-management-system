<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Filament\Resources\LabJobResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitle(fn($record) => $record->code)
            ->columns([
                TextColumn::make('labJob.code')
                    ->label('Nomor Lab Job')
                    ->searchable()
                    ->sortable()
                    ->url(
                        fn($record) => $record->labJob
                            ? LabJobResource::getUrl('view', ['record' => $record->labJob->id])
                            : null
                    )
                    ->openUrlInNewTab()
                    ->tooltip(fn($record) => $record->labJob ? 'Lihat Lab Job' : 'Tidak ada Lab Job terkait'),
                TextColumn::make('code')
                    ->label('Nomor Tagihan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Tanggal Tagihan')
                    ->date()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Tanggal Jatuh Tempo')
                    ->date()
                    ->sortable(),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('Diskon')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tax_rate')
                    ->label('Pajak')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Jumlah Total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->numeric()
                    ->sortable(),
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
                SelectFilter::make('lab_job_id')
                    ->label('Lab Job')
                    ->relationship('labJob', 'code')
                    ->searchable()
                    ->preload(),

            ], layout: FiltersLayout::AboveContent)
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
