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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('customer_type_id');


            $table->string('name')->unique();
            $table->string('full_address')->nullable();

            $table->string('postal_code')->nullable();
            // contact person
            $table->string('contact_person_name');
            $table->string('contact_person_title')->nullable();
            $table->string('contact_phone_number');
            $table->string('contact_email')->nullable();
            $table->string('npwp')->nullable();

            $table->date('registration_date');
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();


            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
