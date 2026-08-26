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
        Schema::create('sample_histories', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->unsignedBigInteger('personel_id');
            $table->unsignedBigInteger('sample_id');
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
        Schema::dropIfExists('sample_histories');
    }
};
