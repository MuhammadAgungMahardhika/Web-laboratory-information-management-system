<?php

namespace App\Filament\Resources\Samples\Tables;

use App\Filament\Resources\LabJobResource\Actions\SampleAction;
use App\Models\Enums\SampleStatusEnum;
use App\Services\SampleService;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SamplesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('labJobItem'))
            ->groups([
                Group::make('labJobItem.description')
                    ->label(''),
            ])
            ->defaultGroup('labJobItem.description')
            ->columns([
                TextColumn::make('sample_code')
                    ->label('Kode Sampel')
                    ->searchable(),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => SampleStatusEnum::labels()[$state])
                    ->badge()
                    ->color(fn($state) => SampleStatusEnum::color($state))
                    ->sortable()
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
                SampleAction::prepare()
                    ->modalHeading('Sampel siap untuk diuji')
                    ->modalDescription('Apakah anda yakin untuk mengubah status sampel menjadi siap diuji? '),
                EditAction::make(),
                ViewAction::make(),

            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->after(
                        function (RelationManager $livewire) {
                            $livewire->dispatch('refresh');
                        }
                    ),
                    BulkAction::make('Siapkan')
                        ->icon(Heroicon::OutlinedDocumentCheck)
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $sampleService = new SampleService();
                            $successCount = 0;
                            $failedCount = 0;

                            foreach ($records as $record) {
                                try {
                                    DB::transaction(function () use ($sampleService, $record) {
                                        $sampleService->updateSampleStatus($record, SampleStatusEnum::Prepared);
                                    });

                                    $successCount++;
                                } catch (\Exception $e) {
                                    $failedCount++;
                                }
                            }
                            if ($successCount > 0) {
                                Notification::make()
                                    ->title("Berhasil menyiapkan sampel uji")
                                    ->body("{$successCount} sample berhasil untuk disiapkan.")
                                    ->success()
                                    ->send();
                            }
                            if ($failedCount > 0) {
                                Notification::make()
                                    ->title("Gagal menyiapkan sampel uji")
                                    ->body("{$failedCount} sample gagal untuk disiapkan.")
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
