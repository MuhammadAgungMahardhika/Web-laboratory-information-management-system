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
        Schema::create('lab_jobs', function (Blueprint $table) {
            $table->id(); // Primary Key, auto-increment
            $table->unsignedBigInteger('quotation_id');
            $table->string('job_number', 50)->unique(); // Kode unik Job

            $table->date('start_date')->nullable(); // Tanggal Job dimulai
            $table->date('end_date')->nullable(); // Tanggal Job selesai

            // Menggunakan enum string values secara langsung
            $table->tinyInteger('status')->default(1);

            // Kolom auditing standar
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
        Schema::dropIfExists('lab_jobs');
    }
};
