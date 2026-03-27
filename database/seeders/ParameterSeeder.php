<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ParameterSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('/csv/parameter.csv');

        if (!File::exists($csvFile)) {
            return;
        }

        $csvData = array_map('str_getcsv', file($csvFile));

        foreach ($csvData as $row) {

            $code = isset($row[0]) ? trim($row[0]) : null;
            $testMethodId = isset($row[6]) && $row[6] !== '' ? $row[6] : null;

            if ($code === null || $code === '') {
                continue;
            }

            $statusRaw = isset($row[2]) ? trim($row[2]) : null;
            $status = $this->convertStatus($statusRaw);

            $longName = isset($row[1]) && $row[1] !== '' ? trim($row[1]) : null;
            $standardNotes = isset($row[3]) && $row[3] !== '' ? trim($row[3]) : null;

            // 🔥 CEK DUPLIKAT BERDASARKAN 3 FIELD
            $exists = DB::table('parameters')
                ->where('long_name', $longName)
                ->where('status', $status)
                ->where('standard_notes', $standardNotes)
                ->exists();

            if ($exists) {
                continue; // skip jika sama persis
            }

            $data = [
                'code'           => $code,
                'long_name'      => $longName,
                'unit'           => isset($row[4]) && $row[4] !== '' ? trim($row[4]) : null,
                'status'         => $status,
                'default_price'  => $this->parseDecimal($row[5] ?? null),
                'test_method_id' => $testMethodId,
                'standard_notes' => $standardNotes,
            ];

            DB::table('parameters')->insert($data);
        }
    }

    private function parseDecimal(?string $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Hapus tanda kutip & spasi
        $value = trim($value);

        // Hapus pemisah ribuan (.)
        $value = str_replace('.', '', $value);

        // Ganti koma jadi titik
        $value = str_replace(',', '.', $value);

        return is_numeric($value) ? (float) $value : null;
    }
    /**
     * Konversi status dari string ke integer
     * A = 1, N/A = 2, S = 3
     */
    private function convertStatus(?string $status): ?int
    {
        if ($status === null || $status === '') {
            return null;
        }

        // Trim dan uppercase untuk memastikan
        $statusClean = strtoupper(trim($status));

        return match ($statusClean) {
            'A' => 1,
            'NA' => 2,
            'S' => 3,
            default => null,
        };
    }
}
