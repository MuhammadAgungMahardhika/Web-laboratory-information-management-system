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
            $testMethodId = $row[5] ?? null;

            // Skip jika name kosong (ini satu-satunya validasi)
            if ($name === null || $name === '') {
                continue;
            }

            // Cek duplikat
            $exists = DB::table('parameters')
                ->where('name', $name)
                ->where(function ($q) use ($testMethodId) {
                    if ($testMethodId === null || $testMethodId === '') {
                        $q->whereNull('test_method_id');
                    } else {
                        $q->where('test_method_id', $testMethodId);
                    }
                })
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('parameters')->insert([
                'id'             => $row[0] ?? null,
                'name'           => $name,
                'unit'           => $row[2] ?? null,
                'status'         => $row[3] ?? null,
                'default_price'  => $row[4] ?? null,
                'test_method_id' => $testMethodId ?: null,
                'description'    => $row[6] ?? null,

            ]);
        }
    }
}
