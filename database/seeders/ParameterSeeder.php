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

            $code = $this->clean($row[0] ?? null);
            if (empty($code)) continue;

            $longName = $this->clean($row[1] ?? null);
            $status = $this->convertStatus($this->clean($row[2] ?? 2));
            $standardNotes = $this->clean($row[3] ?? null);
            $unit = $this->clean($row[4] ?? null);
            $price = $this->parseDecimal($row[5] ?? 0);

            // 🔥 Test Method
            $testMethodName = $this->clean($row[6] ?? null);
            $testMethodId = null;

            if (!empty($testMethodName)) {
                $method = DB::table('test_methods')
                    ->whereRaw('LOWER(TRIM(name)) = ?', [strtolower($testMethodName)])
                    ->first();

                if ($method) {
                    $testMethodId = $method->id;
                } else {
                    logger("Test method tidak ditemukan: " . $testMethodName);
                }
            }

            // 🔥 Cek duplikat (FULL MATCH)
            $query = DB::table('parameters')
                ->where('long_name', $longName)
                ->where('status', $status);

            $query->when(
                $standardNotes === null,
                fn($q) => $q->whereNull('standard_notes'),
                fn($q) => $q->where('standard_notes', $standardNotes)
            );

            $query->when(
                $unit === null,
                fn($q) => $q->whereNull('unit'),
                fn($q) => $q->where('unit', $unit)
            );

            $query->when(
                $testMethodId === null,
                fn($q) => $q->whereNull('test_method_id'),
                fn($q) => $q->where('test_method_id', $testMethodId)
            );

            if ($query->exists()) {
                continue;
            }

            DB::table('parameters')->insert([
                'code'           => $code,
                'long_name'      => $longName,
                'unit'           => $unit,
                'status'         => $status ?? 2,
                'default_price'  => $price ?? 0,
                'test_method_id' => $testMethodId,
                'standard_notes' => $standardNotes,
            ]);
        }
    }

    /**
     * 🔥 CLEANER SUPER PENTING
     */
    private function clean(?string $value): ?string
    {
        if ($value === null) return null;

        // Remove BOM & invisible chars
        $value = preg_replace('/[\x00-\x1F\x7F\xA0]/u', ' ', $value);

        // Normalize unicode symbols
        $replace = [
            'µ' => 'u',
            '²' => '2',
            '³' => '3',
            '₀' => '0',
            '₁' => '1',
            '₂' => '2',
            '₃' => '3',
            '₄' => '4',
            '₅' => '5',
            '₆' => '6',
            '₇' => '7',
            '₈' => '8',
            '₉' => '9',
        ];

        $value = str_replace(array_keys($replace), array_values($replace), $value);

        // Normalize spacing
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value) !== '' ? trim($value) : null;
    }

    private function parseDecimal(?string $value): ?float
    {
        if ($value === null || $value === '') return null;

        $value = trim($value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return is_numeric($value) ? (float) $value : null;
    }

    private function convertStatus(?string $status): ?int
    {
        if ($status === null) return null;

        return match (strtoupper($status)) {
            'A' => 1,
            'NA' => 2,
            'S' => 3,
            default => null,
        };
    }
}
