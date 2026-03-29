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

        foreach ($csvData as $index => $row) {

            // Skip header (optional)
            if ($index === 0) {
                continue;
            }

            $code = isset($row[0]) ? trim($row[0]) : null;

            if (empty($code)) {
                continue;
            }

            // 🔥 Ambil nama metode dari CSV (kolom 6)
            $testMethodName = isset($row[6]) ? trim($row[6]) : null;
            $testMethodId = null;

            if (!empty($testMethodName)) {

                // Normalisasi spasi
                $testMethodName = preg_replace('/\s+/', ' ', $testMethodName);

                $method = DB::table('test_methods')
                    ->whereRaw('LOWER(name) = ?', [strtolower($testMethodName)])
                    ->first();

                if ($method) {
                    $testMethodId = $method->id;
                } else {
                    // ⚠️ Optional: skip atau log jika metode tidak ditemukan
                    continue;
                }
            }

            $statusRaw = isset($row[2]) ? trim($row[2]) : null;
            $status = $this->convertStatus($statusRaw);

            $longName = isset($row[1]) && $row[1] !== '' ? trim($row[1]) : null;
            $standardNotes = isset($row[3]) && $row[3] !== '' ? trim($row[3]) : null;

            // 🔥 Cek duplikat
            $exists = DB::table('parameters')
                ->where('long_name', $longName)
                ->where('status', $status)
                ->where('standard_notes', $standardNotes)
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('parameters')->insert([
                'code'           => $code,
                'long_name'      => $longName,
                'unit'           => isset($row[4]) ? trim($row[4]) : null,
                'status'         => $status,
                'default_price'  => $this->parseDecimal($row[5] ?? null),
                'test_method_id' => $testMethodId,
                'standard_notes' => $standardNotes,
            ]);
        }
    }

    private function parseDecimal(?string $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = trim($value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return is_numeric($value) ? (float) $value : null;
    }

    private function convertStatus(?string $status): ?int
    {
        if ($status === null || $status === '') {
            return null;
        }

        $statusClean = strtoupper(trim($status));

        return match ($statusClean) {
            'A' => 1,
            'NA' => 2,
            'S' => 3,
            default => null,
        };
    }
}
