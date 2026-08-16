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
            $table->string('code')->unique();
            $table->date('date');
            $table->date('due_date');

            // Financial Summaries

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('dpp_amount', 15, 2)->default(0);
            $table->decimal('ppn_percentage', 5, 2)->default(0);
            $table->decimal('ppn_amount', 15, 2)->default(0);
            $table->decimal('pph_percentage', 5, 2)->default(0);
            $table->decimal('pph_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2)->default(0);

            // Status (Misal: Draft, Sent, Paid, Void)
            $table->tinyInteger('status')->default(1);

            // Audit
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

            // Index
            $table->index('code');
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
