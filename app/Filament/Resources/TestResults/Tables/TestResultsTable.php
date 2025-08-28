<?php

namespace App\Filament\Resources\TestResults\Tables;

use App\Models\Enums\PositionEnum;
use App\Models\Enums\RoleEnum;
use App\Models\Enums\TestResultStatusEnum;
use Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use View;

class TestResultsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $user = Auth::user();
                $personel = $user->personel;
                if ($personel && $personel->position->name === PositionEnum::Analyst->value) {
                    // Filter untuk hanya menampilkan hasil yang parameternya sesuai keahlian analis ini
                    return $query->whereHas('parameter', fn($q) => $q->whereHas('personels', fn($qi) => $qi->where('personel_id', $personel->id)));
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
                    ->color(Color::Green)
                    ->label('Nilai')
                    ->searchable(),
                TextColumn::make('corrected_value')
                    ->alignEnd()
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
                    ->label('Nilai Standar Maksimum'),
                TextColumn::make('standard_min_value_ref')
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
