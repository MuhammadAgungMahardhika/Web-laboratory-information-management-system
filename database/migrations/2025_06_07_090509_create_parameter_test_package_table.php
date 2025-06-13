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
        Schema::create('parameter_test_package', function (Blueprint $table) {
            $table->id(); // Primary Key, auto-increment
            $table->unsignedBigInteger('test_package_id');
            $table->unsignedBigInteger('parameter_id');


            // Kolom auditing standar
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            // Unique constraint for combination
            $table->unique(['test_package_id', 'parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_test_package');
    }
};
