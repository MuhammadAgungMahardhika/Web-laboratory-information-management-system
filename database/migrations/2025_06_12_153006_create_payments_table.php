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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relasi ke Invoice (Wajib ada)
            $table->string('code')->unique();
            $table->string('receipt_number')->unique()->nullable(); // Nomor kuitansi, hanya diisi jika status Completed
            $table->unsignedBigInteger('invoice_id'); // Jika invoice dihapus, record pembayaran ikut dihapus

            // Detail Transaksi
            $table->date('date');
            $table->decimal('amount_paid', 15, 2);
            $table->string('payment_method', 50); // Ex: 'Transfer', 'Cash', 'Credit Card'
            $table->string('reference_number', 255)->nullable(); // Nomor referensi bank/transaksi
            $table->text('notes')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('attachment_path')->nullable(); // Path ke file bukti pembayaran
            $table->dateTime('paid_at')->nullable(); // Tanggal pembayaran diterima, hanya diisi jika status Completed
            // Status (Misal: Draft, Sent, Paid, Void)
            $table->tinyInteger('status')->default(1);
            // Audit
            $table->index('code');
            $table->index('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
