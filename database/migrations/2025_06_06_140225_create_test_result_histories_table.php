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
            $table->string('old_tested_value')->nullable();
            $table->string('new_tested_value')->nullable();
            $table->text('comment')->nullable();

            $table->tinyInteger('action');
            $table->json('changes')->nullable();

            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('action');
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
