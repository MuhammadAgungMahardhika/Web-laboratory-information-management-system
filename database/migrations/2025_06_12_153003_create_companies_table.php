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
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            // Company General Information
            $table->string('name')->unique(); // Company Name
            $table->text('address')->nullable(); // Company Address

            $table->string('postal_code', 20)->nullable(); // Company Postal Code
            $table->string('phone', 50)->nullable(); // Company Phone Number
            $table->string('email')->nullable(); // Company Contact Email
            $table->string('website')->nullable(); // Company Website URL
            $table->string('npwp', 50)->nullable(); // Company NPWP

            // To ensure only ONE company record exists for global settings
            $table->boolean('is_main_company')->default(true)->unique();

            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('is_main_company');
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
