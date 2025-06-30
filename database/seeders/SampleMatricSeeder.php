<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class SampleMatricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file CSV
        $csvFile = database_path('/csv/sample_matric.csv');

        // Buka file CSV
        if (File::exists($csvFile)) {
            // Baca file CSV
            $csvData = array_map('str_getcsv', file($csvFile));
            foreach ($csvData as $row) {
                DB::table('sample_matrics')->insert([
                    'id' => $row[0],
                    'sample_type_id' => $row[1],
                    'code' => $row[2],
                    'name' => $row[3],
                    'description' => $row[4],
                ]);
            }
        }
    }
}
