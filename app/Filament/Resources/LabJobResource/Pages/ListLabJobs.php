<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\LabJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords; // Pastikan ini diimpor
use Illuminate\Database\Eloquent\Builder; // Pastikan ini diimpor
use App\Models\Enums\JobStatusEnum; // Pastikan ini diimpor
use App\Models\LabJob; // Pastikan ini diimpor

class ListLabJobs extends ListRecords
{
    protected static string $resource = LabJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $counts = LabJob::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $workflowStatuses = [
            JobStatusEnum::Draft,
            JobStatusEnum::Sampling,
            JobStatusEnum::SamplingCompleted,
            JobStatusEnum::AnalysisCompleted,
            JobStatusEnum::JobCompleted,
        ];

        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA')
                ->badge($counts->sum())
                ->badgeColor('gray'),
        ];

        foreach ($workflowStatuses as $status) {
            $count = $counts[$status->value] ?? 0;

            $tabs[$status->value] = Tab::make($status->value)
                ->label(strtoupper($status->label()))
                ->badge($count)
                ->badgeColor(
                    $count > 0
                        ? JobStatusEnum::color($status->value)
                        : 'gray'
                )
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where(
                        'status',
                        $status->value
                    )
                );
        }

        return $tabs;
    }
}
