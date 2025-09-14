<?php

namespace App\Filament\Resources\TestResults\Tables;

use App\Filament\Resources\TestResults\Actions\TestResultAction;
use App\Models\Enums\PositionEnum;
use App\Models\Enums\TestResultStatusEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TestResultsTable
{
    public static function configure(Table $table): Table
    {
        $user = Auth::user();
        $personel = $user->personel;
        $specializationIds = !is_null($personel->personelSpecializations())
            ? $personel->personelSpecializations()->pluck('specialization_id')->toArray()
            : [];
        return $table
            ->modifyQueryUsing(function ($query) use ($personel, $specializationIds) {
                return $query->whereHas('parameter.specialisasiParameters', function ($q) use ($specializationIds) {
                    $q->whereIn('specialization_id', $specializationIds);
                });
            })
            ->striped()
            ->groups([
                Group::make('sample.sample_code')
                    ->label('Kode sampel')
                    ->titlePrefixedWithLabel(false),
                Group::make('sample.labJobItem.description')
                    ->label('Matrix')
                    ->titlePrefixedWithLabel(false),
                Group::make('parameter.name')
                    ->label('Parameter')
                    ->titlePrefixedWithLabel(false),
            ])
            ->defaultGroup('sample.sample_code')
            ->columns([
                TextColumn::make('sample.labJobItem.description')
                    ->label('Matrix')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('sample.sample_code')
                    ->label('Kode sampel')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')->formatStateUsing(fn($state) => TestResultStatusEnum::labels()[$state])->badge()->color(fn($state) => TestResultStatusEnum::color($state))->searchable()
                    ->sortable(),
                TextColumn::make('parameter.name')->label('Parameter')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('testMethod.name')->label('Metode')
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
                TextColumn::make('analystPersonel.fullname')->label('Analis')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('validatorPersonel.fullname')->label('Validator')
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
                SelectFilter::make('sample.labJobItem.lab_job_id')
                    ->label('Nomor Job')
                    ->relationship('sample.labJobItem.labJob', 'job_number')
                    ->searchable()
                    ->preload(),
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
                EditAction::make()->slideOver()->extraModalFooterActions([
                    TestResultAction::requestValidate(),
                    TestResultAction::validate()
                ]),
                ViewAction::make()->slideOver()->modalFooterActions([
                    TestResultAction::requestValidate(),
                    TestResultAction::validate(),
                    TestResultAction::revisionNeeded(),
                    TestResultAction::reject(),
                ]),

            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    TestResultAction::bulkRequestValidate(),
                    TestResultAction::bulkValidate(),
                    TestResultAction::bulkRevisionNeeded(),
                    TestResultAction::bulkReject()
                ]),
            ]);
    }
}
