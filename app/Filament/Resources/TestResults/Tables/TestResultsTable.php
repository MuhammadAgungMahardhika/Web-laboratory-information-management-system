<?php

namespace App\Filament\Resources\TestResults\Tables;

use App\Filament\Resources\TestResults\Actions\TestResultAction;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\TestResult;
use App\Services\TestResultApprovalService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class TestResultsTable
{

    /**
     * User dianggap "approver" kalau punya salah satu permission
     * approve-test-result-level-*. Cuma approver yang boleh lihat BML & hasil evaluasi.
     */
    public static function isApprover(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        foreach (TestResultApprovalService::LEVEL_PERMISSIONS as $permission) {
            if ($user->can($permission)) {
                return true;
            }
        }

        return false;
    }
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->groups([
                Group::make('sample.code')->label('KODE SAMPEL'),
                Group::make('sample.labJobItem.description')->label('Matrix')->titlePrefixedWithLabel(false),
                Group::make('parameter.long_name')->label('Parameter')->titlePrefixedWithLabel(false),
            ])
            ->defaultGroup('sample.code')
            ->columns([
                TextColumn::make('parameter.long_name')
                    ->label('Parameter')
                    ->searchable()
                    ->html()
                    ->formatStateUsing(
                        fn(TestResult $record) => new HtmlString(
                            view('components.parameter-info', [
                                'record' => $record,
                            ])->render()
                        )
                    ),

                ViewColumn::make('approval_flow')
                    ->label('Approval')
                    ->action(TestResultAction::approvalHistory())
                    ->view('components.approval-summary'),

                TextColumn::make('sample.code')
                    ->label('Sample')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query
                            ->whereHas(
                                'sample',
                                fn($q) =>
                                $q->where('code', 'like', "%{$search}%")
                            )
                            ->orWhereHas(
                                'sample.labJobItem',
                                fn($q) =>
                                $q->where('description', 'like', "%{$search}%")
                            );
                    })
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        $matrix = e($record->sample?->labJobItem?->description);

                        return <<<HTML
                                    <div class="font-semibold text-gray-900">
                                        {$state}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        {$matrix}
                                    </div>
                                HTML;
                    })->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('standard_notes_ref')->label('BML')->visible(fn() => static::isApprover()),
                TextColumn::make('tested_value')
                    ->label('Pengujian')
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
                    ->relationship('sample.labJobItem.labJob', 'code')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('sample_id')
                    ->label('Kode sampel')
                    ->relationship('sample', 'code')
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
                EditAction::make()
                    ->slideOver()
                    ->modalSubmitAction(function (Action $action, TestResult $record) {
                        $action->keyBindings(['ctrl+s']);
                        if ($record->status === TestResultStatusEnum::RevisionNeeded->value) {
                            $action->label('Perbaiki Draft');
                        } else {
                            $action->label('Simpan Draft');
                        }
                        return $action;
                    })
                    ->mutateDataUsing(function (array $data, TestResult $record) {
                        if ($record->status === TestResultStatusEnum::RevisionNeeded->value) {
                            $data['status'] = TestResultStatusEnum::Raw->value;
                        }
                        return $data;
                    })
                    ->after(function (TestResult $record, array $arguments, TestResultApprovalService $service) {
                        // baca argument yang ditempel tombol saveAndRequestValidate()
                        if (!($arguments['requestValidate'] ?? false)) {
                            return;
                        }
                        $result = $service->submitForValidation($record);

                        if ($result['success']) {
                            Notification::make()->title($result['message'])->success()->send();
                        } else {
                            Notification::make()->title($result['message'])->danger()->send();
                        }
                    })
                    ->modalWidth(Width::SixExtraLarge)
                    ->extraModalFooterActions(fn(Action $action): array => [
                        $action->makeModalSubmitAction('saveAndRequestValidate', arguments: ['requestValidate' => true])
                            ->label(fn(TestResult $record) => $record->status === TestResultStatusEnum::RevisionNeeded->value
                                ? 'Perbaiki & Request Validasi'
                                : 'Simpan & Request Validasi')
                            ->icon(Heroicon::ArrowUpTray)
                            ->color('warning')
                            ->requiresConfirmation()
                            ->visible(
                                fn(TestResult $record) =>
                                Auth::user()->can(TestResultAction::PERMISSION_REQUEST_VALIDATE_TEST_RESULT)
                                    && in_array($record->status, [
                                        TestResultStatusEnum::Raw->value,
                                        TestResultStatusEnum::RevisionNeeded->value,
                                    ])
                            ),

                        TestResultAction::validate()->cancelParentActions(),
                        TestResultAction::revisionNeeded()->cancelParentActions(),
                    ])
                    ->modalHeading(fn($record) => "{$record->parameter->code} - Sampel {$record->sample->code}")
                    ->modalIcon(Heroicon::Beaker)
                    ->modalIconColor(fn($record) => $record && $record->status ? TestResultStatusEnum::color($record->status) : 'primary'),
                ViewAction::make()->slideOver()->modalFooterActions([
                    TestResultAction::requestValidate()->cancelParentActions(),
                    TestResultAction::validate()->cancelParentActions(),
                    TestResultAction::revisionNeeded()->cancelParentActions(),
                    TestResultAction::reject()->cancelParentActions(),
                ])
                    ->modalWidth(Width::SixExtraLarge)
                    ->modalHeading(fn($record) => "{$record->parameter->code} - Sampel {$record->sample->code}")
                    ->modalIcon(Heroicon::Beaker)
                    ->modalIconColor(fn($record) => $record && $record->status ? TestResultStatusEnum::color($record->status) : 'primary'),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->authorize(fn() => Auth::user()->can('delete-test-result')),
                    TestResultAction::bulkRequestValidate(),
                    TestResultAction::bulkValidate(),
                    TestResultAction::bulkRevisionNeeded(),
                    TestResultAction::bulkReject(),
                ]),
            ]);
    }
}
