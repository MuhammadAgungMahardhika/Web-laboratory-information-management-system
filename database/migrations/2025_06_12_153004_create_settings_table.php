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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('letterhead_path')->nullable(); // Path to the uploaded letterhead image
            $table->integer('default_quotation_expiry_days')->default(30)->nullable();
            $table->unsignedBigInteger('term_template_id')->nullable();

            // Mail SMTP Settings (for dynamic mail configuration)
            $table->string('mail_mailer')->default('smtp')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable(); // Use string for port as it can be '2525'
            $table->string('mail_username')->nullable();
            $table->text('mail_password')->nullable(); // Use TEXT for encrypted password
            $table->string('mail_encryption')->nullable();
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();

            $table->boolean('is_active')->default(true);

            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
