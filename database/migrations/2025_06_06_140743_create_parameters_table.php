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
            $table->string('code', 20)->unique();
            $table->string('long_name', 255)->unique();
            $table->string('unit', 50);

            $table->text('description')->nullable();
            $table->decimal('default_price', 15, 2)->nullable();
            $table->tinyInteger('status')->default(1)->nullable();

            // standard value
            $table->decimal('standard_max_value', 10, 4)->nullable();
            $table->decimal('standard_min_value', 10, 4)->nullable();
            $table->string('standard_unit', 50)->nullable();
            $table->string('standard_notes', 255)->nullable();


            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('code');
            $table->index('long_name');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
