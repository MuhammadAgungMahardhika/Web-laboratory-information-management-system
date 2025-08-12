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
        Schema::create('parameter_lab_job_items', function (Blueprint $table) {
            $table->id();

            // Foreign keys (sementara tanpa constraint)
            $table->unsignedBigInteger('lab_job_item_id');
            $table->unsignedBigInteger('parameter_id');

            // Snapshot data dari master parameter
            $table->string('parameter_name', 255)->nullable();
            $table->string('parameter_unit', 50)->nullable();
            $table->decimal('parameter_default_price')->nullable();
            $table->string('parameter_default_test_method_name', 50)->nullable();
            $table->text('parameter_description')->nullable();
            $table->enum('parameter_status', ["accredited", "unaccredited"])->nullable();

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
        Schema::dropIfExists('parameter_lab_job_items');
    }
};
