<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\CustomerType;
use App\Models\Province;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan tabel-tabel terkait sudah ada dan memiliki data.
        // Asumsi User Seeder sudah jalan dan ada user dengan ID 1
        $userId = User::first()->id ?? null; // Ambil ID user pertama, atau null jika tidak ada

        // Ambil ID dari Provinsi dan Kota yang sudah di-seed
        $province = Province::where('name', 'DKI JAKARTA')->first();
        $city = City::where('name', 'KOTA JAKARTA PUSAT')->first();

        // Ambil ID dari Tipe Pelanggan yang sudah di-seed
        $customerType = CustomerType::where('name', 'Perusahaan')->first();

        // Jika salah satu data relasi tidak ditemukan, bisa log error atau return
        if (!$customerType) {
            $this->command->error("CustomerType 'Perusahaan' not found. Please seed customer_types table first.");
            return;
        }

        DB::table('customers')->insert([
            'user_id' => $userId, // Akan diisi dengan ID user pertama jika ada, atau null
            'province_id' => $province->id ?? null, // Akan diisi jika provinsi ditemukan
            'city_id' => $city->id ?? null,         // Akan diisi jika kota ditemukan
            'customer_type_id' => $customerType->id, // Wajib diisi

            'name' => 'PT. Laju Jaya Mandiri',
            'full_address' => 'Jl. Merdeka Raya No. 10, Gambir',
            'postal_code' => '10110',
            'contact_person_name' => 'Budi Santoso',
            'contact_person_title' => 'Manajer',
            'contact_phone_number' => '081234567890',
            'contact_email' => 'contact@lajujaya.com',
            'npwp' => '01.234.567.8-901.234',
            'registration_date' => Carbon::now()->subMonths(6)->toDateString(), // 6 bulan lalu
            'status' => 'active', // Enum: 'active' atau 'inactive'

            'created_by' => 'system_seeder', // Isi dengan nilai default atau ID user jika ada Blameable trait
            'updated_by' => 'system_seeder',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->command->info('Customer data seeded successfully!');
    }
}
