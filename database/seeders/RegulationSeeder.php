<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Enums\RegulationTypeEnum;

class RegulationSeeder extends Seeder
{
    public function run(): void
    {
        // Path ke file CSV
        $csvFile = database_path('/csv/regulation.csv');

        // Buka file CSV
        if (File::exists($csvFile)) {
            // Baca file CSV
            $csvData = array_map('str_getcsv', file($csvFile));
            foreach ($csvData as $row) {
                DB::table('regulations')->insert([
                    'regulation_type_id' => $row[0],
                    'name' => $row[1],
                    'long_name' => $row[2],
                ]);
            }
        }
    }
}
