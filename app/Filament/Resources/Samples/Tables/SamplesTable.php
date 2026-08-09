<?php

namespace App\Filament\Resources\Samples\Tables;

use App\Filament\Resources\Samples\Actions\SampleAction;
use App\Models\Enums\SampleStatusEnum;
use App\Models\Sample;
use App\Services\SampleService;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class SamplesTable
{

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }
    public static function configure(Table $table): Table
    {
        $sampleService  = app(SampleService::class);
        return $table
            ->selectCurrentPageOnly()
            ->groups([
                Group::make('labJobItem.code')
                    ->label('Nomor Produk Uji')
                    ->titlePrefixedWithLabel(false),
                Group::make('labJobItem.description')
                    ->label('Matrix')
                    ->titlePrefixedWithLabel(false),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultGroup('labJobItem.code')
            ->columns([
                TextColumn::make('sample_information')
                    ->label('Informasi Sampel')
                    ->state(function ($record) {
                        $statusLabel = SampleStatusEnum::labels()[$record->status];
                        $statusColor = SampleStatusEnum::color($record->status);

                        $colors = [
                            'success' => '#16a34a',
                            'warning' => '#d97706',
                            'danger'  => '#dc2626',
                            'primary' => '#2563eb',
                            'gray'    => '#6b7280',
                            'info'    => '#0891b2',
                        ];

                        $color = $colors[$statusColor] ?? '#6b7280';

                        return new HtmlString("
                            <div style='line-height:1.5'>
                                <div><strong>Matrix</strong> : {$record->labJobItem->description}</div>
                                <div><strong>Kode</strong> : {$record->code}</div>
                                <div>
                                    <strong>Status</strong> :
                                    <span style='color: {$color}; font-weight: 600;'>{$statusLabel}</span>
                                </div>
                            </div>
                        ");
                    })
                    ->html()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('code', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhereHas('labJobItem', function ($q) use ($search) {
                                $q->where('description', 'like', "%{$search}%");
                            });
                    }),
                TextColumn::make('personel')
                    ->label('Personel')
                    ->state(fn($record) => new HtmlString("
                        <div style='line-height:1.5'>
                            <div><strong>PPC</strong> : {$record->collectedByPersonel?->fullname}</div>
                            <div><strong>Penerima</strong> : {$record->receivedByPersonel?->fullname}</div>
                        </div>
                    "))
                    ->html()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereHas('collectedByPersonel', fn($q) => $q->where('fullname', 'like', "%{$search}%"))
                            ->orWhereHas('receivedByPersonel', fn($q) => $q->where('fullname', 'like', "%{$search}%"));
                    }),
                TextColumn::make('collection_information')
                    ->label('Pengambilan')
                    ->state(fn($record) => new HtmlString("
                            <div style='line-height:1.5'>
                                <div><strong>Tanggal</strong> : " . \Carbon\Carbon::parse($record->collection_date)->format('d-m-Y') . "</div>
                                <div><strong>Waktu</strong> : " . \Carbon\Carbon::parse($record->collection_time)->format('H:i') . "</div>
                            </div>
                        "))
                    ->html()
                    ->sortable('collection_date')
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->where(function (Builder $query) use ($search) {
                                $query
                                    ->whereDate('collection_date', $search)
                                    ->orWhere('collection_date', 'like', "%{$search}%")
                                    ->orWhere('collection_time', 'like', "%{$search}%");
                            });
                        }
                    ),
                TextColumn::make('received_information')
                    ->label('Penerimaan')
                    ->state(fn($record) => new HtmlString("
                        <div style='line-height:1.5'>
                            <div><strong>Tanggal</strong> : " . ($record->received_date ? \Carbon\Carbon::parse($record->received_date)->format('d-m-Y') : '-') . "</div>
                            <div><strong>Waktu</strong> : " . ($record->received_time ? \Carbon\Carbon::parse($record->received_time)->format('H:i') : '-') . "</div>
                        </div>
                    "))
                    ->html()
                    ->sortable('received_date')
                    ->searchable(
                        query: fn(Builder $query, string $search) => $query
                            ->whereRaw("DATE_FORMAT(received_date, '%d-%m-%Y') LIKE ?", ["%{$search}%"])
                            ->orWhereRaw("TIME_FORMAT(received_time, '%H:%i') LIKE ?", ["%{$search}%"])
                    ),
                TextColumn::make('location')
                    ->label('Koordinat')
                    ->state(fn($record) => new HtmlString("
                            <div style='line-height:1.5'>
                                <div><strong>Lat</strong> : {$record->latitude}</div>
                                <div><strong>Long</strong> : {$record->longitude}</div>
                            </div>
                        "))
                    ->html()
                    ->searchable(query: fn(Builder $query, string $search) => $query
                        ->where('latitude', 'like', "%{$search}%")
                        ->orWhere('longitude', 'like', "%{$search}%")),
                TextColumn::make('container')
                    ->label('Wadah')
                    ->state(fn($record) => new HtmlString("
                        <div style='line-height:1.5'>
                            <div><strong>Jenis</strong> : {$record->container_type}</div>
                            <div><strong>Jumlah</strong> : {$record->container_quantity}</div>
                        </div>
                    "))
                    ->html()
                    ->searchable(query: fn(Builder $query, string $search) => $query
                        ->where('container_type', 'like', "%{$search}%")
                        ->orWhere('container_quantity', 'like', "%{$search}%")),
                TextColumn::make('sample_detail')
                    ->label('Detail Sampel')
                    ->state(fn($record) => new HtmlString("
                            <div style='line-height:1.5'>
                                <div><strong>Volume</strong> : {$record->sample_volume}</div>
                                <div><strong>Preservasi</strong> : {$record->preservation_method}</div>
                            </div>
                        "))
                    ->html()
                    ->searchable(query: fn(Builder $query, string $search) => $query
                        ->where('sample_volume', 'like', "%{$search}%")
                        ->orWhere('preservation_method', 'like', "%{$search}%")),

                TextColumn::make('audit')
                    ->label('Audit')
                    ->state(fn($record) => new HtmlString("
                            <div style='line-height:1.5'>
                                <div><strong>Dibuat</strong> : {$record->created_by}</div>
                                <div><strong>Diubah</strong> : {$record->updated_by}</div>
                            </div>
                        "))
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(query: fn(Builder $query, string $search) => $query
                        ->where('created_by', 'like', "%{$search}%")
                        ->orWhere('updated_by', 'like', "%{$search}%")),
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
                SelectFilter::make('lab_job_item_id')
                    ->label('Nomor Produk Uji')
                    ->relationship('labJobItem', 'code')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('labJobItem.lab_job_id')
                    ->label('Nomor Job')
                    ->relationship('labJobItem.labJob', 'code')
                    ->searchable()
                    ->preload(),


            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ActionGroup::make([
                    SampleAction::downloadLabel(),
                    SampleAction::received(),
                    SampleAction::prepare(),
                ]),
                SampleAction::downloadLabel(),
                SampleAction::prepare(),
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-sample')),
                    BulkAction::make("Diterima")
                        ->icon(Heroicon::OutlinedDocumentCheck)
                        ->color('info')
                        ->requiresConfirmation()
                        ->authorize(static::isAuthorized(SampleAction::PERMISSION_RECEIVING_SAMPLE))
                        ->action(function (Collection $records)  use ($sampleService) {
                            $successCount = 0;
                            $failedCount = 0;

                            foreach ($records as $record) {
                                try {
                                    DB::transaction(function () use ($sampleService, $record) {
                                        $sampleService->updateSampleStatus($record, SampleStatusEnum::Received);
                                    });

                                    $successCount++;
                                } catch (\Exception $e) {
                                    $failedCount++;
                                }
                            }
                            if ($successCount > 0) {
                                Notification::make()
                                    ->title("Berhasil mengubah status sampel")
                                    ->body("{$successCount} sample berhasil untuk diubah.")
                                    ->success()
                                    ->send();
                            }
                            if ($failedCount > 0) {
                                Notification::make()
                                    ->title("Gagal mengubah status sampel")
                                    ->body("{$failedCount} sample gagal untuk diubah.")
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('Proses Analisis')
                        ->icon(Heroicon::OutlinedDocumentCheck)
                        ->color('info')
                        ->requiresConfirmation()
                        ->authorize(static::isAuthorized(SampleAction::PERMISSION_PREPARE))
                        ->action(function (Collection $records)  use ($sampleService) {
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
                                    ->title("Berhasil mengubah status sampel")
                                    ->body("{$successCount} sample berhasil untuk diubah.")
                                    ->success()
                                    ->send();
                            }
                            if ($failedCount > 0) {
                                Notification::make()
                                    ->title("Gagal mengubah status sampel")
                                    ->body("{$failedCount} sample gagal untuk diubah.")
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
