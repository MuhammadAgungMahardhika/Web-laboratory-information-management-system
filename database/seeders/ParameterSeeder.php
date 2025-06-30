<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file CSV
        $csvFile = database_path('/csv/parameter.csv');

        // Buka file CSV
        if (File::exists($csvFile)) {
            // Baca file CSV
            $csvData = array_map('str_getcsv', file($csvFile));
            foreach ($csvData as $row) {
                DB::table('parameters')->insert([
                    'id' => $row[0],
                    'name' => $row[1],
                    'unit' => $row[2],
                    'default_price' => $row[3],
                    'test_method_id' => $row[4],
                    'description' => $row[5],
                    'status' => $row[6],
                ]);
            }
        }
    }
}
