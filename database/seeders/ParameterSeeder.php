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

            $code = isset($row[1]) ? trim($row[1]) : null;
            $testMethodId = isset($row[6]) && $row[6] !== '' ? $row[6] : null;

            // Skip jika name kosong (ini satu-satunya validasi)
            if ($code === null || $code === '') {
                continue;
            }

            // Cek duplikat
            $exists = DB::table('parameters')
                ->where('code', $code)
                ->where(function ($q) use ($testMethodId) {
                    if ($testMethodId === null) {
                        $q->whereNull('test_method_id');
                    } else {
                        $q->where('test_method_id', $testMethodId);
                    }
                })
                ->exists();

            if ($exists) {
                continue;
            }

            // Konversi status dari string ke integer
            $statusRaw = isset($row[4]) ? trim($row[4]) : null;
            $status = $this->convertStatus($statusRaw);

            // Prepare data untuk insert
            $data = [
                'code'           => $code,
                'long_name'      => isset($row[2]) && $row[2] !== '' ? trim($row[2]) : null,
                'unit'           => isset($row[3]) && $row[3] !== '' ? trim($row[3]) : null,
                'status'         => $status,
                'default_price'  => $this->parseDecimal($row[5] ?? null),
                'test_method_id' => $testMethodId,
                'description'    => isset($row[7]) && $row[7] !== '' ? trim($row[7]) : null,
                "standard_notes"  => isset($row[8]) && $row[8] !== '' ? json_encode(array_map('trim', explode(';', $row[8]))) : null,
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
