<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class PersonelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file CSV
        $csvFile = database_path('/csv/personel.csv');

        // Buka file CSV
        if (File::exists($csvFile)) {
            // Baca file CSV
            $csvData = array_map('str_getcsv', file($csvFile));
            array_shift($csvData); // skip header

            foreach ($csvData as $row) {
                DB::table('personels')->insert([
                    'nip' => $row[1],
                    'fullname' => $row[2],
                    'phone_number' => $row[3],
                    'address' => $row[4],
                ]);
            }
        }
    }
}
