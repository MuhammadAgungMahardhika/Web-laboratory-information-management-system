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
        Schema::create('personels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable(); // Assuming you might want to link personels to a company
            $table->unsignedBigInteger('position_id')->nullable(); // Assuming you might want to link personels to a position
            $table->string('nip', 50)->unique()->nullable(); // Using 'nip' as per your provided schema
            $table->string('fullname', 255);
            $table->string('phone_number', 50)->nullable();
            $table->text('address')->nullable();

            // Auditing columns
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('nip');
            $table->index('fullname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personels');
    }
};
