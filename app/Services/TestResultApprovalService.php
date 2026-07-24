<?php

namespace App\Services;

use App\Models\Enums\TestResultApprovalStatusEnum;
use App\Models\Enums\TestResultStatusEnum;
use App\Models\Personel;
use App\Models\TestResult;
use App\Models\TestResultApproval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestResultApprovalService
{
    /** Level approval tertinggi (ubah di sini kalau nambah level) */
    public const MAX_LEVEL = 2;

    /** Mapping level => nama permission */
    public const LEVEL_PERMISSIONS = [
        1 => 'approve-test-result-level-1',
        2 => 'approve-test-result-level-2',
    ];

    private function response(bool $success, string $message): array
    {
        return ['success' => $success, 'message' => $message];
    }

    private function actor(): string
    {
        return Auth::user()?->name ?? 'System';
    }

    /**
     * Ambil data Personel dari user yang sedang login.
     */
    public function getPersonelFromAuth(): ?Personel
    {
        $userId = Auth::id();
        if (!$userId) {
            return null;
        }
        return Personel::where('user_id', $userId)->first();
    }

    /**
     * Apakah user yang login punya permission approve untuk level tertentu.
     */
    public function canApproveLevel(int $level): bool
    {
        $permission = self::LEVEL_PERMISSIONS[$level] ?? null;
        if (!$permission) {
            return false;
        }
        return Auth::user()?->can($permission) ?? false;
    }

    /**
     * Cari approval yang statusnya pending untuk sebuah test result.
     * Bisa dibatasi ke level tertentu, kalau tidak diisi ambil level pending paling rendah.
     */
    public function getPendingApproval(TestResult $testResult, ?int $level = null): ?TestResultApproval
    {
        $query = $testResult->testResultApprovals()
            ->where('status', TestResultApprovalStatusEnum::Pending->value);

        if ($level !== null) {
            $query->where('approval_level', $level);
        }

        return $query->orderBy('approval_level')->latest('id')->first();
    }

    /**
     * Cari approval pending yang levelnya cocok dengan permission user yang sedang login.
     * Ini yang dipakai tombol Filament (satu tombol, otomatis nyesuaikan level).
     */
    public function getPendingApprovalForCurrentUser(TestResult $testResult): ?TestResultApproval
    {
        $pending = $this->getPendingApproval($testResult);

        if (!$pending) {
            return null;
        }

        if (!$this->canApproveLevel($pending->approval_level)) {
            return null;
        }

        return $pending;
    }

    /**
     * Dipanggil ANALIS untuk kirim hasil uji ke validasi.
     * Selalu mulai lagi dari Level 1 (dipakai juga untuk submit ulang setelah RevisionNeeded).
     */
    public function submitForValidation(TestResult $testResult): array
    {
        if (!$testResult->tested_value) {
            return $this->response(false, 'Nilai hasil uji harus diisi sebelum request validasi.');
        }

        TestResultApproval::create([
            'test_result_id' => $testResult->id,
            'personel_id' => null,
            'approval_level' => 1,
            'status' => TestResultApprovalStatusEnum::Pending->value,
            'note' => 'Menunggu persetujuan Level 1',
            'created_by' => $this->actor(),
        ]);

        $testResult->update([
            'status' => TestResultStatusEnum::RequestValidate->value,
            'updated_by' => $this->actor(),
        ]);

        return $this->response(true, 'Hasil uji berhasil dikirim untuk validasi Level 1.');
    }

    /**
     * Aksi 'Approve' / Validasi.
     * $level opsional; kalau null diambil dari approval pending paling rendah.
     */
    public function accept(TestResult $testResult, int $approverPersonelId, ?int $level = null, array $data = []): array
    {
        $pendingApproval = $this->getPendingApproval($testResult, $level);

        if (!$pendingApproval) {
            return $this->response(false, 'Tidak ada persetujuan yang menunggu' . ($level ? " di level {$level}" : '') . '.');
        }

        $currentLevel = $pendingApproval->approval_level;

        if ($pendingApproval->personel_id && $pendingApproval->personel_id !== $approverPersonelId) {
            return $this->response(false, 'Anda tidak ditugaskan untuk menyetujui level ini.');
        }

        $pendingApproval->update([
            'personel_id' => $approverPersonelId,
            'status' => TestResultApprovalStatusEnum::Accepted->value,
            'note' => $data['comment'] ?? ('Disetujui pada Level ' . $currentLevel),
            'updated_by' => $this->actor(),
        ]);

        // Keputusan "sesuai/tidak sesuai BML" hanya diambil di Level 1
        // (level penentuan hasil), level berikutnya cuma pengesahan berjenjang.
        if ($currentLevel === 1) {
            $testResult->update([
                'validator_personel_id' => $approverPersonelId,
                'evaluation_status' => $data['evaluation_status'] ?? $testResult->evaluation_status,
                'test_notes' =>  $data['test_notes'] ?? ""
            ]);
        }

        if ($currentLevel >= self::MAX_LEVEL) {
            $testResult->update([
                'status' => TestResultStatusEnum::Validated->value,
                'validation_date' => now(),
                'updated_by' => $this->actor(),
            ]);
            return $this->response(true, 'Hasil uji berhasil disetujui (Final).');
        }

        $nextLevel = $currentLevel + 1;
        TestResultApproval::create([
            'test_result_id' => $testResult->id,
            'personel_id' => null,
            'approval_level' => $nextLevel,
            'status' => TestResultApprovalStatusEnum::Pending->value,
            'note' => "Menunggu persetujuan Level {$nextLevel}",
            'created_by' => $this->actor(),
        ]);

        $testResult->update([
            'status' => TestResultStatusEnum::RequestValidate->value,
            'updated_by' => $this->actor(),
        ]);

        return $this->response(true, "Berhasil disetujui Level {$currentLevel}. Diteruskan ke Level {$nextLevel}.");
    }
    /**
     * Aksi 'Reject' — final, alur berhenti total (tidak bisa direvisi lagi, harus submit baru).
     */
    public function reject(TestResult $testResult, int $approverPersonelId, string $note, ?int $level = null): array
    {
        $pendingApproval = $this->getPendingApproval($testResult, $level);

        if (!$pendingApproval) {
            return $this->response(false, 'Tidak ada persetujuan yang menunggu.');
        }

        if ($pendingApproval->personel_id && $pendingApproval->personel_id !== $approverPersonelId) {
            return $this->response(false, 'Anda tidak ditugaskan menolak level ini.');
        }

        $pendingApproval->update([
            'personel_id' => $approverPersonelId,
            'status' => TestResultApprovalStatusEnum::Rejected->value,
            'note' => $note,
            'updated_by' => $this->actor(),
        ]);

        $testResult->update([
            'status' => TestResultStatusEnum::Rejected->value,
            'comment' => $note,
            'updated_by' => $this->actor(),
        ]);

        return $this->response(true, 'Hasil uji berhasil ditolak.');
    }

    /**
     * Aksi 'Request Revision'.
     *
     * - Level 1 minta revisi -> balik ke ANALIS (status RevisionNeeded, wajib submit ulang dari Level 1).
     * - Level > 1 minta revisi -> TIDAK balik ke analis, cukup turun ke level sebelumnya
     *   (misal Level 2 minta revisi -> dibuatkan approval Level 1 pending baru).
     */
    public function requestRevision(TestResult $testResult, int $approverPersonelId, string $note, ?int $level = null): array
    {
        $pendingApproval = $this->getPendingApproval($testResult, $level);

        if (!$pendingApproval) {
            return $this->response(false, 'Tidak ada persetujuan yang menunggu.');
        }

        $currentLevel = $pendingApproval->approval_level;

        if ($pendingApproval->personel_id && $pendingApproval->personel_id !== $approverPersonelId) {
            return $this->response(false, 'Anda tidak ditugaskan revisi level ini.');
        }

        $pendingApproval->update([
            'personel_id' => $approverPersonelId,
            'status' => TestResultApprovalStatusEnum::Revision->value,
            'note' => "Revisi Diperlukan: {$note}",
            'updated_by' => $this->actor(),
        ]);

        // Level 1 -> balik ke analis
        if ($currentLevel <= 1) {
            $testResult->update([
                'status' => TestResultStatusEnum::RevisionNeeded->value,
                'comment' => $note,
                'revision_count' => $testResult->revision_count + 1,
                'updated_by' => $this->actor(),
            ]);

            Log::info("TestResult #{$testResult->id} dikembalikan ke analis untuk revisi.");

            return $this->response(true, 'Dikembalikan ke analis untuk revisi.');
        }

        // Level > 1 -> turun ke level sebelumnya, TIDAK ke analis
        $backToLevel = $currentLevel - 1;

        // Cari siapa approver sebelumnya di level itu (biar bisa jadi assignee lagi, opsional saja)
        $previousApproverId = $testResult->testResultApprovals()
            ->where('approval_level', $backToLevel)
            ->where('status', TestResultApprovalStatusEnum::Accepted->value)
            ->orderByDesc('id')
            ->value('personel_id');

        TestResultApproval::create([
            'test_result_id' => $testResult->id,
            'personel_id' => $previousApproverId, // null diperbolehkan, tidak mengunci siapa yang approve
            'approval_level' => $backToLevel,
            'status' => TestResultApprovalStatusEnum::Pending->value,
            'note' => "Revisi dari Level {$currentLevel}: {$note}",
            'created_by' => $this->actor(),
        ]);

        $testResult->update([
            'status' => TestResultStatusEnum::RequestValidate->value, // tetap di alur validasi, tidak balik ke analis
            'comment' => $note,
            'revision_count' => $testResult->revision_count + 1,
            'updated_by' => $this->actor(),
        ]);

        return $this->response(true, "Dikembalikan ke Level {$backToLevel} untuk revisi.");
    }
}
