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
            $table->unsignedBigInteger('test_method_id');
            $table->string('name', 255)->unique();
            $table->string('unit', 50);

            $table->text('description')->nullable();
            $table->decimal('default_price');
            $table->enum('status', ['accredited', 'unaccredited'])->default('accredited');

            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
