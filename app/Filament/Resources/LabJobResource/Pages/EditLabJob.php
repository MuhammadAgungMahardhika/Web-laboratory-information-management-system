<?php

namespace App\Filament\Resources\LabJobResource\Pages;

use App\Filament\Resources\LabJobResource;
use App\Models\Enums\JobStatusEnum;
use App\Models\LabJob;
use App\Models\Personel;
use App\Services\LabJobService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;


class EditLabJob extends EditRecord
{
    protected static string $resource = LabJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ActionGroup::make([
                // Aksi: Tugaskan Tim PPC
                Action::make('Tugaskan Tim PPC')
                    ->icon('heroicon-o-users')
                    ->color('info')
                    // Hanya tampil jika status 'pending_start'
                    ->visible(fn(LabJob $record) => $record->status === JobStatusEnum::PendingStart->value)
                    ->form([
                        Select::make('ketua_ppc_id')
                            ->label('Pilih Ketua PPC')
                            ->options(Personel::all()->pluck('fullname', 'id'))
                            ->searchable()
                            ->required()
                            ->preload(),
                        Select::make('anggota_ppc_ids')
                            ->label('Pilih Anggota PPC')
                            ->options(Personel::all()->pluck('fullname', 'id'))
                            ->multiple()
                            ->searchable()
                            ->preload(),
                    ])
                    ->action(function (LabJob $record, array $data) {
                        try {
                            $labJobService = new LabJobService();
                            DB::transaction(function () use ($record, $data, $labJobService) {
                                // Hapus semua penugasan anggota lama
                                $record->labJobPersonels()->delete();
                                // 2. Tambahkan Anggota PPC ke tabel lab_job_personels (jika ada)
                                if (!empty($data['anggota_ppc_ids'])) {
                                    $anggotaPpcData = [];
                                    foreach ($data['anggota_ppc_ids'] as $anggotaId) {
                                        if ($anggotaId != $data['ketua_ppc_id']) { // Pastikan ketua tidak ditambahkan lagi
                                            $anggotaPpcData[] = ['personel_id' => $anggotaId];
                                        }
                                    }
                                    // Menggunakan createMany untuk menyimpan banyak data sekaligus
                                    $record->labJobPersonels()->createMany($anggotaPpcData);
                                }

                                // 3. Perbarui status pekerjaan lab
                                $labJobService->updateLabJobStatus($record, JobStatusEnum::InProgress);
                            });
                            Notification::make()->title('Tim PPC berhasil ditugaskan dan pekerjaan dimulai.')->success()->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal menugaskan tim PPC')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // Aksi: Cetak Surat Tugas
                // Action::make('Cetak Surat Tugas')
                //     ->icon('heroicon-o-document-arrow-down')
                //     ->color('primary')
                //     // Hanya tampil jika PPC sudah ditugaskan
                //     ->visible(fn(LabJob $record) => $record->personels->isNotEmpty()),
            ])
                ->label('Aksi Pekerjaan') // Label untuk tombol dropdown utama
                ->icon('heroicon-o-briefcase')
                ->color('gray'),
        ];
    }
}
