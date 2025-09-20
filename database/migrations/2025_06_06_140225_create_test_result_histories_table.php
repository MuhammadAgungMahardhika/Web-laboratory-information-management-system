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
        Schema::create('test_result_histories', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('personel_id');
            $table->unsignedBigInteger('test_result_id');

            // Perubahan status dan nilai
            $table->tinyInteger('old_status');
            $table->tinyInteger('new_status');

            // tested value
            $table->decimal('old_tested_value', 10, 4)->nullable();
            $table->decimal('new_tested_value', 10, 4)->nullable();

            // corrected value
            $table->decimal('old_corrected_value', 10, 4)->nullable();
            $table->decimal('new_corrected_value', 10, 4)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_result_histories');
    }
};
