<?php

namespace App\Filament\Resources\TestResults\Tables;

use App\Models\Enums\PositionEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Services\TestResultService;
use Auth;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TestResultsTable
{
    public static function configure(Table $table): Table
    {
        $user = Auth::user();
        $personel = $user->personel;
        $specializationIds = $personel
            ? $personel->personelSpecializations()->pluck('specialization_id')->toArray()
            : [];
        return $table
            ->modifyQueryUsing(function ($query) use ($personel, $specializationIds) {
                if ($personel && $personel->position->name === PositionEnum::Analyst->value) {
                    return $query
                        ->select('test_results.*')
                        ->join('parameters', 'parameters.id', '=', 'test_results.parameter_id')
                        ->join('specialisasi_parameters', 'specialisasi_parameters.parameter_id', '=', 'parameters.id')
                        ->whereIn('specialisasi_parameters.specialization_id', $specializationIds)
                        ->distinct();
                }
                return $query;
            })
            ->striped()
            ->groups([
                Group::make('sample.sample_code')
                    ->label(''),
            ])
            ->defaultGroup('sample.sample_code')
            ->columns([
                TextColumn::make('sample.sample_code')
                    ->label('Kode sampel')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')->formatStateUsing(fn($state) => TestResultStatusEnum::labels()[$state])->badge()->color(fn($state) => TestResultStatusEnum::color($state))->searchable()
                    ->sortable(),
                TextColumn::make('parameter.name')->label('Parameter uji')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('testMethod.name')->label('Metode uji')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tested_value')
                    ->alignEnd()
                    ->numeric()
                    ->color(Color::Green)
                    ->label('Nilai')
                    ->searchable(),
                TextColumn::make('corrected_value')
                    ->alignEnd()
                    ->numeric()
                    ->color(Color::Green)
                    ->label('Nilai terkoreksi')
                    ->searchable(),
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->searchable(),
                TextColumn::make('test_date')
                    ->label('Tanggal uji')
                    ->date()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('standard_max_value_ref')
                    ->numeric()
                    ->label('Nilai Standar Maksimum'),
                TextColumn::make('standard_min_value_ref')
                    ->numeric()
                    ->label('Nilai Standar Minimum'),
                TextColumn::make('standard_unit_ref')
                    ->label('Satuan Standar'),
                TextColumn::make('standard_notes_ref')
                    ->label('Catatan Standar'),
                TextColumn::make('analyst_personel.fullname')->label('Analis')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('validator_personel.fullname')->label('Validator')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('validation_date')
                    ->label('Tanggal Validasi')
                    ->dateTime()
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
                SelectFilter::make('sample_id')
                    ->label('Kode sampel')
                    ->relationship('sample', 'sample_code')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('parameter_id')
                    ->label('Parameter uji')
                    ->relationship('parameter', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('method_id')
                    ->label('Metode uji')
                    ->relationship('testMethod', 'name')
                    ->searchable()
                    ->preload()
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),

            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('requestValidate')
                        ->label('Request Validasi')
                        ->icon(Heroicon::ArrowUpTray)
                        ->requiresConfirmation()
                        ->color('warning')
                        ->action(function (Collection $records) {
                            $testResultService = new TestResultService();
                            $successCount = 0;
                            $failedCount = 0;
                            foreach ($records as $record) {
                                try {
                                    DB::transaction(function () use ($testResultService, $record) {
                                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::RequestValidate);
                                    });
                                    $successCount++;
                                } catch (\Exception $e) {
                                    $failedCount++;
                                }
                            }
                            if ($successCount > 0) {
                                Notification::make()
                                    ->title("Request Validasi Berhasil")
                                    ->body("{$successCount} hasil uji berhasil untuk request validasi.")
                                    ->success()
                                    ->send();
                            }
                            if ($failedCount > 0) {
                                Notification::make()
                                    ->title("Request Validasi Gagal")
                                    ->body("{$failedCount} hasil uji gagal untuk request validasi.")
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('validate')
                        ->label('Validasi Hasil Uji')
                        ->icon(Heroicon::Check)
                        ->requiresConfirmation()
                        ->color('success')
                        ->action(function (Collection $records) {
                            $testResultService = new TestResultService();
                            $successCount = 0;
                            $failedCount = 0;
                            foreach ($records as $record) {
                                try {
                                    DB::transaction(function () use ($testResultService, $record) {
                                        $testResultService->updateTestResultStatus($record, TestResultStatusEnum::Validated);
                                    });
                                    $successCount++;
                                } catch (\Exception $e) {
                                    $failedCount++;
                                }
                            }
                            if ($successCount > 0) {
                                Notification::make()
                                    ->title("Validasi Berhasil")
                                    ->body("{$successCount} hasil uji berhasil divalidasi.")
                                    ->success()
                                    ->send();
                            }
                            if ($failedCount > 0) {
                                Notification::make()
                                    ->title("Validasi Gagal")
                                    ->body("{$failedCount} hasil uji gagal divalidasi.")
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion()
                ]),
            ]);
    }
}
