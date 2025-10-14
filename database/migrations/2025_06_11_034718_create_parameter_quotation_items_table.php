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
        Schema::create('parameter_quotation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_item_id');
            $table->unsignedBigInteger('parameter_id')->nullable();

            // Snapshot data dari master parameter
            $table->string('parameter_name', 255)->nullable();
            $table->string('parameter_unit', 50)->nullable();
            $table->decimal('parameter_default_price')->nullable();
            $table->string('parameter_default_test_method_name', 50)->nullable();
            $table->text('parameter_description')->nullable();
            $table->enum('parameter_status', [1, 2, 3, 4, 5])->nullable();

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
        Schema::dropIfExists('parameter_quotation_items');
    }
};
