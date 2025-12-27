<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Enums\RegulationTypeEnum;

class RegulationTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Path ke file CSV
        $csvFile = database_path('/csv/regulation_type.csv');

        // Buka file CSV
        if (File::exists($csvFile)) {
            // Baca file CSV
            $csvData = array_map('str_getcsv', file($csvFile));
            foreach ($csvData as $row) {
                DB::table('regulation_types')->insert([
                    'name' => $row[0],
                    'long_name' => $row[1],
                ]);
            }
        }
    }
}
