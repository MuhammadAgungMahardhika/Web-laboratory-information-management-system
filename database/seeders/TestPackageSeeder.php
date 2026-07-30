<?php

namespace Database\Seeders;

use App\Models\SampleMatric;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('test_packages')->insert([
            'name' => "Air Limbah",
            'code' => "ALdom",
            'regulation_id' => 3,
            'price' => 9000000,
            'is_active' => true,
        ]);
    }
}
