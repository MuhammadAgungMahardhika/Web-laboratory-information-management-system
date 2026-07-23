<?php

namespace App\Filament\Resources\TestResults\Tables;

use App\Filament\Resources\TestResults\Actions\TestResultAction;
use App\Models\Enums\TestResultApprovalStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TestResultsTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->groups([
                Group::make('sample.sample_code')->label('KODE SAMPEL'),
                Group::make('sample.labJobItem.description')->label('Matrix')->titlePrefixedWithLabel(false),
                Group::make('parameter.long_name')->label('Parameter')->titlePrefixedWithLabel(false),
            ])
            ->defaultGroup('sample.sample_code')
            ->columns([
                TextColumn::make('sample.labJobItem.description')
                    ->label('Matrix')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parameter.long_name')
                    ->label('Parameter')
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHas('parameter', function ($q) use ($search) {
                            $q->where('long_name', 'like', "%{$search}%");
                        });
                    })
                    ->html()
                    ->formatStateUsing(function ($state, TestResult $record) {

                        $status = TestResultStatusEnum::labels()[$record->status];
                        $color = TestResultStatusEnum::cssColor($record->status);

                        $pending = $record->test_result_approvals()
                            ->where('status', TestResultApprovalStatusEnum::Pending->value)
                            ->orderBy('approval_level')
                            ->first();

                        $levelInfo = $pending
                            ? "<span style='font-size:11px;color:#6B7280;'>Menunggu Level {$pending->approval_level}</span>"
                            : '';

                        return "
            <div style='display:flex;flex-direction:column;gap:4px;'>
                <div style='font-weight:600;'>
                    " . e($state) . "
                </div>

                <div style='font-size:12px;color:#6B7280;'>
                    " . e($record->testMethod?->name ?? '-') . "
                </div>

                <div style='display:flex;align-items:center;gap:6px;flex-wrap:wrap;'>

                    <span
                        style='
                            display:inline-block;
                            padding:2px 10px;
                            border-radius:999px;
                            font-size:11px;
                            font-weight:600;
                            color:white;
                            background:{$color};
                        '
                    >
                        {$status}
                    </span>

                    {$levelInfo}

                </div>
            </div>
        ";
                    }),

                TextColumn::make('tested_value')
                    ->label('Hasil Uji')
                    ->html()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->where(function ($q) use ($search) {
                                $q->where('tested_value', 'like', "%{$search}%")
                                    ->orWhere('unit', 'like', "%{$search}%")
                                    ->orWhere('standard_notes_ref', 'like', "%{$search}%");
                            });
                        }
                    )
                    ->formatStateUsing(function ($state, TestResult $record) {
                        $html = "
                <div class='font-semibold text-success-600'>
                    " . e($state) . " " . e($record->unit) . "
                </div>
            ";

                        if (Auth::user()->can('approve-test-result-level-1') || Auth::user()->can('approve-test-result-level-2')) {
                            $html .= "
                    <div class='text-xs text-gray-500 mt-1'>
                        <strong>BML</strong> : 
                        " . e($record->standard_notes_ref ?: '-') . "
                    </div>
                ";
                        }

                        return $html;
                    }),

                TextColumn::make('analystPersonel.fullname')
                    ->label('Petugas')
                    ->html()
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query
                                ->whereHas('analystPersonel', function ($q) use ($search) {
                                    $q->where('fullname', 'like', "%{$search}%");
                                })
                                ->orWhereHas('validatorPersonel', function ($q) use ($search) {
                                    $q->where('fullname', 'like', "%{$search}%");
                                });
                        }
                    )
                    ->formatStateUsing(function ($state, TestResult $record) {
                        return "
                <div class='space-y-2'>
                    <div>
                        <div class='text-xs text-gray-500'>
                            Analis  :  " . e($record->analystPersonel?->fullname ?? '-') . "
                        </div>
                    </div>
                  
                </div>
            ";
                    }),

                TextColumn::make('test_date')
                    ->label('Tanggal')
                    ->html()
                    ->sortable()
                    ->formatStateUsing(function ($state, TestResult $record) {
                        $uji = $record->test_date
                            ? Carbon::parse($record->test_date)->format('d M Y')
                            : '-';

                        $validasi = $record->validation_date
                            ? Carbon::parse($record->validation_date)->format('d M Y H:i')
                            : '-';

                        return "
                <div class='space-y-2'>
                    <div>
                        <div class='text-xs text-gray-500'>
                            Uji : {$uji}
                        </div>
                    </div>
                    <div>
                        <div class='text-xs text-gray-500'>
                            Validasi :   {$validasi}
                        </div>
                    </div>
                </div>
            ";
                    }),

                TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
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
                    ->relationship('parameter', 'code')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('method_id')
                    ->label('Metode uji')
                    ->relationship('testMethod', 'name')
                    ->searchable()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make()->slideOver()
                    ->modalSubmitAction(function (Action $action, TestResult $record) {
                        $action->keyBindings(['ctrl+s']);
                        if ($record->status === TestResultStatusEnum::RevisionNeeded->value) {
                            $action->label('Perbaiki');
                        }
                        return $action;
                    })
                    ->mutateDataUsing(function (array $data, TestResult $record) {
                        if ($record->status === TestResultStatusEnum::RevisionNeeded->value) {
                            $data['status'] = TestResultStatusEnum::Raw->value;
                        }
                        return $data;
                    })
                    ->modalWidth(Width::SixExtraLarge)
                    ->extraModalFooterActions([
                        TestResultAction::requestValidate()->cancelParentActions(),
                        TestResultAction::validate()->cancelParentActions(),
                        TestResultAction::revisionNeeded()->cancelParentActions(),
                    ])
                    ->modalHeading(fn($record) => "{$record->parameter->code} - Sampel {$record->sample->sample_code}")
                    ->modalIcon(Heroicon::Beaker)
                    ->modalIconColor(fn($record) => $record && $record->status ? TestResultStatusEnum::color($record->status) : 'primary'),

                ViewAction::make()->slideOver()->modalFooterActions([
                    TestResultAction::requestValidate()->cancelParentActions(),
                    TestResultAction::validate()->cancelParentActions(),
                    TestResultAction::revisionNeeded()->cancelParentActions(),
                    TestResultAction::reject()->cancelParentActions(),
                ])
                    ->modalWidth(Width::SixExtraLarge)
                    ->modalHeading(fn($record) => "{$record->parameter->code} - Sampel {$record->sample->sample_code}")
                    ->modalIcon(Heroicon::Beaker)
                    ->modalIconColor(fn($record) => $record && $record->status ? TestResultStatusEnum::color($record->status) : 'primary'),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    TestResultAction::bulkRequestValidate(),
                    TestResultAction::bulkValidate(),
                    TestResultAction::bulkRevisionNeeded(),
                    TestResultAction::bulkReject(),
                ]),
            ]);
    }
}
