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
        Schema::create('term_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama template (misal: "Standard BNI", "Termin 2x Pembayaran")
            $table->text('content'); // Isi template (HTML/teks kaya untuk RichEditor)
            $table->boolean('is_active')->default(true); // Apakah template aktif/bisa dipilih

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
        Schema::dropIfExists('term_templates');
    }
};
