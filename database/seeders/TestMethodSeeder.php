<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TestMethodSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('/csv/test_method.csv');

        if (!File::exists($csvFile)) {
            return;
        }

        $csvData = array_map('str_getcsv', file($csvFile));

        foreach ($csvData as $row) {
            // Skip jika name sudah ada
            $exists = DB::table('test_methods')
                ->where('name', trim($row[1]))
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('test_methods')->insert([
                'id'          => $row[0],
                'name'        => trim($row[1]),
                'description' => $row[2] ?? null,
            ]);
        }
    }
}
