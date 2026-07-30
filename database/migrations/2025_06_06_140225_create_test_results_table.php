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
            $table->unsignedBigInteger('parameter_id')->nullable();
            $table->unsignedBigInteger('test_method_id')->nullable();
            $table->unsignedBigInteger('analyst_personel_id')->nullable();
            $table->unsignedBigInteger('validator_personel_id')->nullable();

            // Pengujian dan data terkait
            $table->string('tested_value')->nullable();
            // $table->decimal('corrected_value', 10, 4)->nullable();
            $table->string('unit', 50)->nullable();
            $table->date('test_date')->nullable();
            $table->text('test_notes')->nullable();

            // Data standar referensi
            $table->string('standard_notes_ref', 255)->nullable();

            // Status validasi
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('revision_count')->default(0);
            $table->tinyInteger('evaluation_status')->nullable();
            $table->timestamp('validation_date')->nullable();

            // Auditing columns
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('evaluation_status');
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
