<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsAppService
{
    // Properti ini tidak lagi mutlak diperlukan untuk link wa.me, tapi bisa tetap ada untuk API lain
    // protected string $apiUrl;
    // protected string $apiKey;
    // protected string $senderNumber;

    // Konstruktor bisa dikosongkan atau disederhanakan jika tidak pakai API
    public function __construct()
    {
        // Jika tidak ada API, tidak perlu inisialisasi ini
    }

    /**
     * Generate a direct WhatsApp link to send a message with a document URL.
     * This link will open WhatsApp application.
     *
     * @param string $to The recipient's phone number (e.g., '6281234567890')
     * @param string $message The text message to pre-fill.
     * @param string $documentUrl The public URL of the document to include in the message.
     * @return string The wa.me link.
     */
    public function getWhatsAppDirectLink(string $to, string $message, string $documentUrl): string
    {
        // Nomor telepon harus dimulai dengan kode negara tanpa '+'
        $cleanTo = preg_replace('/^\+/', '', $to); // Hapus '+' jika ada
        if (!Str::startsWith($cleanTo, '62')) { // Asumsi nomor Indonesia, jika belum ada 62
            $cleanTo = '62' . ltrim($cleanTo, '0'); // Tambah 62 dan hapus 0 di depan
        }

        // Encode pesan dan URL dokumen
        $encodedMessage = urlencode($message . "\n\nDokumen Anda: " . $documentUrl);

        return "https://wa.me/{$cleanTo}?text={$encodedMessage}";
    }

    // Metode sendTextMessage dan sendDocument sebelumnya bisa dihapus
    // atau dipertahankan jika ada rencana untuk integrasi API nanti.
}
