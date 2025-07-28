<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('quotation_id')->unsigned();
            $table->bigInteger('test_package_id')->unsigned()->nullable();
            $table->bigInteger('regulation_id')->unsigned()->nullable();

            // duplikat data from test package
            $table->string('description', 255);
            $table->string('regulation_name', 255)->nullable();
            $table->decimal('price', 15, 2);

            $table->integer('quantity');
            $table->string('unit', 50);
            $table->string('location', 100)->nullable();


            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};
