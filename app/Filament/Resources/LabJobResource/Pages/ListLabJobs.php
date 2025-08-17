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

    // public function getDefaultActiveTab(): string|int|null
    // {
    //     return JobStatusEnum::PendingStart->value; // Menggunakan enum untuk mendapatkan status default
    // }
    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('all')
                ->label('SEMUA'),
        ];

        foreach (JobStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->value)
                ->badge(LabJob::query()->where('status', $status->value)->count())
                ->badgeColor(JobStatusEnum::color($status->value))
                ->label(strtoupper($status->label()))
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
