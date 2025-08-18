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
            $table->unsignedBigInteger('lab_job_item_id');
            $table->unsignedBigInteger('sample_matric_id');
            $table->unsignedBigInteger('collected_by_personel_id')->nullable();
            $table->unsignedBigInteger('received_by_personel_id')->nullable();
            // Sample details
            $table->string('sample_code', 50)->unique();
            $table->date('collection_date');
            $table->time('collection_time');
            $table->text('collection_location_desc')->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('container_type', 100)->nullable();
            $table->integer('container_quantity')->default(1);
            $table->string('sample_volume', 50)->nullable();
            $table->string('preservation_method', 255)->nullable();
            $table->text('collection_notes')->nullable();
            $table->date('received_date');
            $table->time('received_time');
            $table->text('received_condition_notes')->nullable();

            // Status
            $table->enum('status', [
                'received',
                'prepared',
                'in_analysis',
                'analysis_completed',
                'invalid',
                'archived'
            ])->default('received');

            // Auditing columns
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();


            $table->index('status');
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
