<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\LabJob;
use App\Models\LabJobItem;
use App\Models\QuotationItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    /**
     * Menghasilkan nomor faktur baru yang unik dan berurutan per bulan.
     * Format: INV-YYMM-XXX
     */
    public function generateInvoiceNumber(LabJob $labJob): string
    {
        // 1. Ambil code sebagai informasi
        $jobNumber = $labJob->code;

        // 2. Ambil format tanggal
        $currentYearMonth = Carbon::now()->format('ym'); // Contoh: 2510

        // 3. Hitung urutan berdasarkan SEMUA invoice di bulan ini (Logika yang Benar)
        $count = Invoice::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // 4. Buat nomor urut 3 digit
        $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        // 5. Gabungkan semuanya menjadi format yang informatif
        return "INV-{$jobNumber}-{$currentYearMonth}-{$sequence}";
    }

    /**
     * Membuat Invoice lengkap dari LabJob menggunakan transaksi database.
     */
    public function createInvoiceFromLabJob(LabJob $labJob, array $data): Invoice
    {
        // Gunakan transaksi untuk memastikan semua data tersimpan dengan aman

        // 1. Buat record Invoice
        $invoice = Invoice::create([
            'lab_job_id' => $labJob->id,
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'],
            'discount' => $data['discount'] ?? 0,
            'tax_rate' => $data['tax_rate'] ?? 0,
            'invoice_number' => $this->generateInvoiceNumber($labJob), // <-- Panggil generator di sini
        ]);

        // 2. Salin Item Tipe A dari LabJobItem
        foreach ($labJob->labJobItems as $jobItem) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'source_type' => LabJobItem::class,
                'source_id' => $jobItem->id,
                'description' => $jobItem->description,
                'price' => $jobItem->price,
                'quantity' => $jobItem->quantity,
            ]);
        }

        // 3. Salin Item Tipe B & C dari Quotation
        if ($labJob->quotation) { // Pastikan relasi quotation ada
            $otherItems = $labJob->quotation->quotationItems()
                ->whereIn('group', ['B', 'C'])
                ->get();

            foreach ($otherItems as $quotationItem) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'source_type' => QuotationItem::class,
                    'source_id' => $quotationItem->id,
                    'description' => $quotationItem->description,
                    'price' => $quotationItem->price,
                    'quantity' => $quotationItem->quantity,
                ]);
            }
        }

        // Anda bisa menambahkan logika untuk menghitung total_amount di sini
        // $invoice->recalculateTotals();
        return $invoice;
    }
}
