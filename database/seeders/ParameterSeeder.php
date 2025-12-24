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

            $name = isset($row[1]) ? trim($row[1]) : null;
            $testMethodId = isset($row[6]) && $row[6] !== '' ? $row[6] : null;

            // Skip jika name kosong (ini satu-satunya validasi)
            if ($name === null || $name === '') {
                continue;
            }

            // Cek duplikat
            $exists = DB::table('parameters')
                ->where('name', $name)
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
                'name'           => $name,
                'long_name'      => isset($row[2]) && $row[2] !== '' ? trim($row[2]) : null,
                'unit'           => isset($row[3]) && $row[3] !== '' ? trim($row[3]) : null,
                'status'         => $status,
                'default_price'  => isset($row[5]) && $row[5] !== '' ? trim($row[5]) : null,
                'test_method_id' => $testMethodId,
                'description'    => isset($row[7]) && $row[7] !== '' ? trim($row[7]) : null,
            ];

            DB::table('parameters')->insert($data);
        }
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
