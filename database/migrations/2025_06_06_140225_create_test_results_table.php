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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();

            // Foreign keys (sementara tanpa constraint)
            $table->unsignedBigInteger('sample_id');
            $table->unsignedBigInteger('parameter_id');
            $table->unsignedBigInteger('test_method_id');
            $table->unsignedBigInteger('analyst_personel_id')->nullable();
            $table->unsignedBigInteger('validator_personel_id')->nullable();

            // Hasil uji dan data terkait
            $table->string('tested_value', 100)->nullable();
            $table->string('corrected_value', 100)->nullable();
            $table->string('unit', 50);
            $table->date('test_date')->nullable();
            $table->text('test_notes')->nullable();

            // Data standar referensi
            $table->decimal('standard_max_value_ref', 10, 4)->nullable();
            $table->decimal('standard_min_value_ref', 10, 4)->nullable();
            $table->string('standard_unit_ref', 50)->nullable();
            $table->string('standard_notes_ref', 255)->nullable();

            // Status validasi
            $table->enum('status', [
                'raw',
                'validated',
                'clarification_needed',
                'revision_needed',
                'rejected'
            ])->default('raw');
            $table->timestamp('validation_date')->nullable();

            // Auditing columns
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
