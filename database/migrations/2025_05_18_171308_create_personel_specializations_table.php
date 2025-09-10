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
        Schema::create('personel_specializations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personel_id');
            $table->unsignedBigInteger('specialization_id');
            $table->string('file_path')->nullable();

            // Auditing columns
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->unique(['personel_id', 'specialization_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personel_specializations');
    }
};
