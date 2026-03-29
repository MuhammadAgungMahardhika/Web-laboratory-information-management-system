<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TestMethodSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('/csv/test_method.csv');

        if (!File::exists($csvFile)) {
            return;
        }

        $csvData = array_map('str_getcsv', file($csvFile));

        foreach ($csvData as $index => $row) {

            // Skip header (optional)
            if ($index === 0) {
                continue;
            }

            // Validasi minimal kolom
            if (!isset($row[1])) {
                continue;
            }

            // Bersihkan data
            $name = trim($row[1]);
            $name = preg_replace('/\s+/', ' ', $name); // hapus spasi double

            if (empty($name)) {
                continue;
            }

            // Cek duplikasi (case insensitive)
            $exists = DB::table('test_methods')
                ->whereRaw('LOWER(name) = ?', [strtolower($name)])
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('test_methods')->insert([
                'name'        => $name,
                'description' => isset($row[2]) ? trim($row[2]) : null,
            ]);
        }
    }
}
