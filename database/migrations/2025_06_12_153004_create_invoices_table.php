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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_job_id'); // Mencegah Lab Job dihapus jika sudah ditagih (Audit trail)

            // Snapshot Data
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date');

            // Financial Summaries
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0); // Misal: 11%
            $table->decimal('total_amount', 10, 2);

            // Status (Misal: Draft, Sent, Paid, Void)
            $table->tinyInteger('status')->default(1);

            // Audit
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            // Index
            $table->index('invoice_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
