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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->string('code', 50)->unique();
            $table->unsignedBigInteger('lab_job_item_id');
            $table->unsignedBigInteger('collected_by_personel_id')->nullable();
            $table->unsignedBigInteger('received_by_personel_id')->nullable();
            // Sample  details
            $table->date('collection_date')->nullable();
            $table->time('collection_time')->nullable();
            $table->text('collection_location_desc')->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('preservation_method', 255)->nullable();
            $table->text('collection_notes')->nullable();

            // Sample Received details
            $table->date('received_date')->nullable();
            $table->time('received_time')->nullable();
            $table->text('received_condition_notes')->nullable();
            $table->string('container_type', 100)->nullable();
            $table->integer('container_quantity')->nullable()->default(1);
            $table->string('sample_volume', 50)->nullable();
            // analysy details
            $table->date('analyzed_start_date')->nullable();
            $table->date('analyzed_end_date')->nullable();

            $table->tinyInteger('collection_type')->default(1);
            $table->tinyInteger('status')->default(1);


            // Auditing columns
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();


            $table->index('status');
            $table->index('collection_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
