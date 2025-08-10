<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt; // Import Crypt facade for password encryption
use Carbon\Carbon; // For timestamps

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if a main company record already exists to prevent duplicates
        if (\App\Models\Company::where('is_main_company', true)->exists()) {
            $this->command->info('Main company record already exists. Skipping CompanySeeder.');
            return;
        }

        // --- Fetch sensitive mail credentials from .env ---
        $mailMailer = env('MAIL_MAILER', 'smtp'); // Default to 'smtp' if not set
        $mailHost = env('MAIL_HOST', 'smtp.gmail.com');
        $mailPort = env('MAIL_PORT', '2525'); // Default to '2525' if not set
        $mailEncryption = env('MAIL_ENCRYPTION', 'tls'); // Default to 'tls' if not set
        $mailUsername = env('MAIL_USERNAME', 'your_default_username'); // Provide a fallback if env var is missing
        $mailPassword = env('MAIL_PASSWORD', null); // Get password from .env, null if not set
        $mailFromAddress = env('MAIL_FROM_ADDRESS', 'no-reply@yourcompany.com');
        $mailFromName = env('MAIL_FROM_NAME', 'Your Company Name');
        // --------------------------------------------------
        $jambiProvince = Province::find(15); // ID 5 untuk provinsi Jambi
        $jambiCity = City::find(97); // ID 97 untuk KOTA JAMBI
        // Encrypt the password if it exists
        $encryptedMailPassword = $mailPassword ? Crypt::encryptString($mailPassword) : null;
        $companyId = DB::table('companies')->insertGetId([
            'id' => 1, // Pastikan ID ini unik atau biarkan auto-increment
            'name' => 'PT. Jambi Lestari International',
            'address' => 'Jl. Lintas Timur KM. 12, Kel. Talang Bakung, Kec. Jambi Selatan',
            'province_id' => $jambiProvince->id, // Assuming you have a Province model and the ID for Jambi Province
            'city_id' => $jambiCity->id, // Assuming you have a City model and the ID for Jambi City
            'postal_code' => '36139',
            'phone' => '+62-741-234567',
            'email' => 'info@jambilestari.com',
            'website' => 'www.jambilestari.com',
            'npwp' => '01.234.567.8-901.000',

            'is_main_company' => true,
            'created_by' => 'system',
            'updated_by' => 'system',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $setting = DB::table('settings')->insert([
            'company_id' => $companyId, // <-- Gunakan ID yang dikembalikan
            'letterhead_path' => null,
            'default_quotation_expiry_days' => 30,
            'term_template_id' => null,
            // --- Use values from .env here ---
            'mail_mailer' => $mailMailer,
            'mail_host' => $mailHost,
            'mail_port' => $mailPort,
            'mail_username' => $mailUsername,
            'mail_password' => $encryptedMailPassword,
            'mail_encryption' => $mailEncryption,
            'mail_from_address' => $mailFromAddress,
            'mail_from_name' => $mailFromName,
            // ----------------------------------
        ]);

        $this->command->info('PT. Jambi Lestari International company record seeded successfully!');
    }
}
