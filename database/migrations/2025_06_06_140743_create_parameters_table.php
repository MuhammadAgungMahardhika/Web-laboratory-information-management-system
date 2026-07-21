<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_method_id')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('long_name', 255);
            $table->string('long_name_standard_notes')->virtualAs("IF(standard_notes IS NULL OR standard_notes = '', long_name, CONCAT(long_name, ' (', standard_notes, ')'))");
            $table->string('unit', 50)->nullable();

            $table->text('description')->nullable();
            $table->decimal('default_price', 15, 2)->default(0);
            $table->tinyInteger('status')->default(1);

            // standard value
            $table->integer('tested_time')->nullable();
            $table->string('standard_notes')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('long_name');
            $table->index('long_name_standard_notes');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
