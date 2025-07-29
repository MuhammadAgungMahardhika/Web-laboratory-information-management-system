<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            // Company General Information
            $table->string('name')->unique(); // Company Name
            $table->text('address')->nullable(); // Company Address
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('postal_code', 20)->nullable(); // Company Postal Code
            $table->string('phone', 50)->nullable(); // Company Phone Number
            $table->string('email')->nullable(); // Company Contact Email
            $table->string('website')->nullable(); // Company Website URL
            $table->string('npwp', 50)->nullable(); // Company NPWP

            // Letterhead / Logo Setting
            $table->string('letterhead_path')->nullable(); // Path to the uploaded letterhead image

            // Default Quotation/Document Settings
            $table->integer('default_quotation_expiry_days')->default(30)->nullable(); // Default expiry days for quotations
            // If you later create a terms_templates table, you could add:
            // $table->unsignedBigInteger('default_terms_template_id')->nullable();
            // $table->foreign('default_terms_template_id')->references('id')->on('terms_templates')->onDelete('set null');

            // Mail SMTP Settings (for dynamic mail configuration)
            $table->string('mail_mailer')->default('smtp')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable(); // Use string for port as it can be '2525'
            $table->string('mail_username')->nullable();
            $table->text('mail_password')->nullable(); // Use TEXT for encrypted password
            $table->string('mail_encryption')->nullable();
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();

            // To ensure only ONE company record exists for global settings
            $table->boolean('is_main_company')->default(true)->unique();

            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
