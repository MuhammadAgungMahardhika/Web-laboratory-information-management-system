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
        Schema::create('requests', function (Blueprint $table) {
            $table->id(); // Primary Key, auto-increment
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('lab_job_id');
            $table->string('request_number', 50)->unique(); // Kode unik bisnis (misal: dari form)
            $table->string('request_name', 255); // Nama kegiatan/proyek
            $table->date('request_date'); // Tanggal permohonan
            $table->string('testing_activity_type', 50)->nullable(); // Misal: rutin, bulanan
            $table->text('request_notes')->nullable(); // Catatan permohonan

            // Menggunakan enum string values secara langsung
            $table->enum('request_status', ['submitted_online', 'received_by_admin', 'ready_admin_review', 'pending_admin_clarification', 'ready_technical_review', 'pending_technical_clarification', 'rejected_technical', 'ready_for_quotation', 'quotation_sent', 'quotation_accepted', 'quotation_rejected', 'cancelled_by_customer', 'cancelled_by_lab', 'closed'])->default('submitted_online');

            $table->timestamp('status_update_timestamp')->useCurrent(); // Waktu update status

            $table->string('approved_by_user_id', 255)->nullable(); // User yang menyetujui (misal: ID user dari users table)
            $table->timestamp('approved_at')->nullable(); // Waktu persetujuan

            $table->decimal('ppn_percentage', 5, 2)->default(0.00);
            $table->decimal('pph_percentage', 5, 2)->default(0.00);
            $table->decimal('total_amount', 15, 2); // Total jumlah permohonan (gross)
            $table->text('term_agreements')->nullable(); // Syarat dan ketentuan

            // Kolom auditing standar
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
        Schema::dropIfExists('requests');
    }
};
