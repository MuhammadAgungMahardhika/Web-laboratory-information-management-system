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
        Schema::create('lab_job_items', function (Blueprint $table) {
            $table->id();

            // Foreign keys (sementara tanpa constraint dan indeks)
            $table->unsignedBigInteger('lab_job_id');
            $table->unsignedBigInteger('quotation_item_id')->nullable();
            $table->unsignedBigInteger('test_package_id')->nullable();
            $table->unsignedBigInteger('regulation_id')->nullable();

            // Snapshot/customizable data
            $table->string('description', 255);
            $table->string('regulation_name', 255);
            $table->integer('quantity');
            $table->string('unit', 50);
            $table->decimal('price', 15, 2);
            $table->string('location', 100)->nullable();
            $table->enum('group', ['A', 'B', 'C'])->default('A');

            // Auditing columns
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_job_items');
    }
};
