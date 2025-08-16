<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use App\Filament\Resources\LabJobResource;
use App\Models\Enums\JobStatusEnum;
use App\Models\LabJob;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;

class ViewLabJob extends ViewRecord
{
    protected static string $resource = LabJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('Preview Surat Tugas')
                ->label(fn($record) => $record->labJobPersonels->isNotEmpty() ? 'Preview Surat Tugas' : 'Tidak Ada Surat Tugas')
                ->color(Color::Blue) // Menggunakan warna biru Filament
                ->icon('heroicon-o-eye')
                ->slideOver()
                ->disabled(fn($record) => !$record->labJobPersonels->isNotEmpty())
                ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::InProgress->value)
                ->modalHeading('Pratinjau Surat Tugas')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Tutup Pratinjau')
                ->modalWidth('6xl')
                ->modalContent(function (LabJob $record) {
                    $safeJobNumber = Str::of($record->job_number)->replace('/', '-');
                    $pdfUrl = route('lab_jobs.preview_task_letter', $record);
                    $downloadUrl = route('lab_jobs.download_task_letter', $record);

                    return view('pdfs.preview', [ // Gunakan view modal yang sama
                        'pdfUrl' => $pdfUrl,
                        'safeFileName' => $safeJobNumber,
                        'downloadUrl' => $downloadUrl
                    ]);
                })
                ->modalFooterActions([
                    // Tombol download di footer modal
                    Action::make('Download')
                        ->url(fn(LabJob $record): string => route('lab_jobs.download_task_letter', $record))
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('primary')
                        ->openUrlInNewTab()
                ])
                ->modalFooterActionsAlignment('right'),
        ];
    }
}
