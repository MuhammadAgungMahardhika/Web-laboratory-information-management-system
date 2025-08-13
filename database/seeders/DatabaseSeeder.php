<?php

namespace Database\Seeders;

use App\Models\Position;
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
            ProvinceSeeder::class,
            CitySeeder::class,
            SampleTypeSeeder::class,
            SampleMatricSeeder::class,
            RegulationSeeder::class,
            TestMethodSeeder::class,
            ParameterSeeder::class,
            CustomerTypeSeeder::class,
            CustomerSeeder::class,
            CompanySeeder::class,
            PositionSeeder::class,
            PersonelSeeder::class,
        ]);
    }
}
