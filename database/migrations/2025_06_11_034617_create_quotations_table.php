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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('personel_id')->nullable();

            // Quotation details
            $table->string('quotation_name', 255);
            $table->string('quotation_number', 50)->unique();
            $table->date('quotation_date');
            $table->date('valid_until_date');
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('ppn_percentage', 5, 2)->default(0);
            $table->decimal('pph_percentage', 5, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0); // 'total_amount' is gross as per previous discussion
            $table->text('additional_description')->nullable();

            // Using enum string values directly since Laravel migrations don't automatically recognize PHP Enums
            $table->tinyInteger('status')->default(1);
            // Approval details
            $table->unsignedBigInteger('approved_by_personel_id')->nullable();
            $table->timestamp('approved_at')->nullable();

            // Auditing columns
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            $table->index('quotation_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
