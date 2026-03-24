<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('/csv/param.csv');

        if (!File::exists($csvFile)) {
            return;
        }

        $csvData = array_map('str_getcsv', file($csvFile));

        foreach ($csvData as $row) {

            $code = isset($row[0]) ? trim($row[0]) : null;

            // Skip jika name kosong (ini satu-satunya validasi)
            if ($code === null || $code === '') {
                continue;
            }

            // Cek duplikat
            $exists = DB::table('params')
                ->where('code', $code)
                ->exists();

            if ($exists) {
                continue;
            }

            // Prepare data untuk insert
            $data = [
                'code'           => $code,
                'created_by'    => 'Seeder',
                'updated_by'    => 'Seeder',
            ];

            DB::table('params')->insert($data);
        }
    }
}
