<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            PermissionAndRoleSeeder::class,
            PersonelSeeder::class,
            SampleTypeSeeder::class,
            SampleMatricSeeder::class,
            RegulationSeeder::class,
            TestMethodSeeder::class,
            ParameterSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            CustomerTypeSeeder::class,
            CustomerSeeder::class
        ]);
    }
}
