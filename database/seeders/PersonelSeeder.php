<?php

namespace Database\Seeders;

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

        // create product
        $adminUser =   User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@example.com', // Anda bisa ganti email ini
            'password' => Hash::make('123456'), // Password default yang di-hash
            // 'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('personels')->insert([
            'user_id' => $adminUser->id,
            'fullname' => 'superadmin',
            'nip' => '01.01.01',
            'phone_number' => '',
            'position' =>  '',
            'address' =>  '',
            'certification_details' =>  '',

        ]);

        // asign role
        $adminUser->assignRole('superadmin');
    }
}
