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

        // create product
        $adminUser =   User::factory()->create([
            'name' => 'superadmin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com', // Anda bisa ganti email ini
            'password' => Hash::make('123456'), // Password default yang di-hash
            // 'is_active' => true,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mainCompany = Company::where('is_main_company', true)->first();
        DB::table('personels')->insert([
            'user_id' => $adminUser->id,
            'company_id' => $mainCompany->id, // Assuming the main company has ID 1
            'position_id' => Position::where('name', 'ADMINISTRATOR')->first()->id, // Assuming you have a position named 'ADMINISTRATOR'
            'fullname' => 'superadmin',
            'nip' => '01.01.01',
            'phone_number' => '',
            'address' =>  '',
            'certification_details' =>  '',
        ]);

        // asign role
        $adminUser->assignRole('superadmin');
    }
}
