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
        Schema::create('sample_matrics', function (Blueprint $table) {
            $table->string('code', 12)->unique()->primary();
            $table->unsignedBigInteger('sample_type_id')->nullable();

            $table->string('name', 255)->unique();

            $table->string('code_name', 255)->virtualAs("IF(name IS NULL OR name = '', code, CONCAT(code, ' (', name, ')'))");
            $table->tinyInteger('environment_type')->default(1);
            $table->text('description')->nullable();

            // Kolom auditing standar
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('environment_type');
            $table->index('code');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_matrics');
    }
};
