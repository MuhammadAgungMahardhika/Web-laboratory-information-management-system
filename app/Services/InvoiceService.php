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
     * Generate nomor invoice.
     *
     * Format:
     * INV-{LAB_JOB_CODE}-{YYMM}-{SEQUENCE}
     *
     * Contoh:
     * INV-LJ-001-2608-001
     */
    public function generateInvoiceNumber(LabJob $labJob): string
    {
        $jobNumber = $labJob->code;

        $year = now()->year;
        $month = now()->month;

        $currentYearMonth = now()->format('ym');

        $count = Invoice::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $sequence = str_pad(
            $count + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

        return "INV-{$jobNumber}-{$currentYearMonth}-{$sequence}";
    }

    /**
     * Membuat invoice lengkap berdasarkan Lab Job.
     *
     * Data quotation seperti diskon, PPN dan PPh
     * disimpan sebagai snapshot pada invoice.
     */
    public function createInvoiceFromLabJob(
        LabJob $labJob,
        array $data
    ): Invoice {
        return DB::transaction(function () use ($labJob, $data) {

            $labJob->loadMissing([
                'quotation',
                'labJobItems',
            ]);

            $quotation = $labJob->quotation;

            /*
             * Snapshot financial configuration
             * dari quotation.
             */
            $discountPercentage = (float) (
                $quotation?->discount_percentage ?? 0
            );

            $ppnPercentage = (float) (
                $quotation?->ppn_percentage ?? 0
            );

            $pphPercentage = (float) (
                $quotation?->pph_percentage ?? 0
            );

            /*
             * Buat invoice terlebih dahulu.
             *
             * Semua nilai financial akan dihitung
             * setelah InvoiceItem selesai dibuat.
             */
            $invoice = Invoice::create([
                'lab_job_id' => $labJob->id,

                'date' => $data['date'],
                'due_date' => $data['due_date'],

                'code' => $this->generateInvoiceNumber($labJob),

                'subtotal' => 0,

                'discount_percentage' => $discountPercentage,
                'discount_amount' => 0,

                'dpp_amount' => 0,

                'ppn_percentage' => $ppnPercentage,
                'ppn_amount' => 0,

                'pph_percentage' => $pphPercentage,
                'pph_amount' => 0,

                'total_amount' => 0,
                'net_amount' => 0,

                'status' => 1,
            ]);

            /*
             * ==========================================
             * ITEM LAB JOB
             * ==========================================
             */
            foreach ($labJob->labJobItems as $jobItem) {
                $this->createInvoiceItem(
                    invoice: $invoice,
                    source: $jobItem
                );
            }

            /*
             * ==========================================
             * ITEM QUOTATION B & C
             * ==========================================
             */
            if ($quotation) {
                $quotationItems = $quotation
                    ->quotationItems()
                    ->whereIn('group', ['B', 'C'])
                    ->get();

                foreach ($quotationItems as $quotationItem) {
                    $this->createInvoiceItem(
                        invoice: $invoice,
                        source: $quotationItem
                    );
                }
            }

            /*
             * ==========================================
             * HITUNG TOTAL
             * ==========================================
             */
            $this->recalculateTotals($invoice);

            return $invoice->fresh();
        });
    }

    /**
     * Membuat InvoiceItem dari sumber tertentu.
     *
     * Digunakan untuk:
     * - LabJobItem
     * - QuotationItem
     */
    protected function createInvoiceItem(
        Invoice $invoice,
        LabJobItem|QuotationItem $source
    ): InvoiceItem {
        $quantity = (float) $source->quantity;
        $price = (float) $source->price;

        return InvoiceItem::create([
            'invoice_id' => $invoice->id,

            'source_type' => $source::class,
            'source_id' => $source->id,

            'description' => $source->description,
            'quantity' => $quantity,
            'price' => $price,

            'subtotal' => round(
                $quantity * $price,
                2
            ),
        ]);
    }

    /**
     * Menghitung ulang seluruh financial invoice.
     *
     * Method ini menjadi single source of truth
     * untuk perhitungan invoice.
     */
    public function recalculateTotals(
        Invoice $invoice
    ): Invoice {
        /*
         * Hitung subtotal berdasarkan snapshot
         * InvoiceItem.
         */
        $subtotal = (float) $invoice
            ->invoiceItems()
            ->sum(DB::raw('quantity * price'));

        /*
         * Ambil persentase dari invoice.
         */
        $discountPercentage = (float) ($invoice->discount_percentage ?? 0);
        $ppnPercentage = (float) ($invoice->ppn_percentage ?? 0);
        $pphPercentage = (float) ($invoice->pph_percentage ?? 0);

        /*
         * Pastikan persentase valid.
         */
        $discountPercentage = min(max($discountPercentage, 0), 100);
        $ppnPercentage = min(max($ppnPercentage, 0), 100);
        $pphPercentage = min(max($pphPercentage, 0),  100);

        /*
         * ==========================================
         * DISCOUNT
         * ==========================================
         */
        $discountAmount =  $subtotal *  ($discountPercentage / 100);

        /*
         * ==========================================
         * DPP
         * ==========================================
         */
        $dppAmount = max($subtotal - $discountAmount, 0);

        /*
         * ==========================================
         * PPN
         * ==========================================
         */
        $ppnAmount = $dppAmount * ($ppnPercentage / 100);

        /*
         * ==========================================
         * PPH
         * ==========================================
         */
        $pphAmount = $dppAmount * ($pphPercentage / 100);

        /*
         * ==========================================
         * TOTAL INVOICE
         * ==========================================
         *
         * PPh tidak mengurangi nilai invoice.
         */
        $totalAmount = $dppAmount +  $ppnAmount;

        /*
         * ==========================================
         * NET PAYMENT
         * ==========================================
         *
         * PPh merupakan withholding tax
         * yang dipotong saat pembayaran.
         */
        $netAmount = max($totalAmount - $pphAmount,  0);

        /*
         * ==========================================
         * SIMPAN
         * ==========================================
         */
        $invoice->update([
            'subtotal'            => round($subtotal, 2),
            'discount_percentage' => round($discountPercentage, 2),
            'discount_amount'     => round($discountAmount, 2),
            'dpp_amount'          => round($dppAmount, 2),
            'ppn_percentage'      => round($ppnPercentage, 2),
            'ppn_amount'          => round($ppnAmount, 2),
            'pph_percentage'      => round($pphPercentage, 2),
            'pph_amount'          => round($pphAmount, 2),
            'total_amount'        => round($totalAmount, 2),
            'net_amount'          => round($netAmount, 2),
        ]);

        return $invoice->fresh();
    }

    /**
     * Menghitung nilai financial tanpa menyimpan ke database.
     *
     * Digunakan oleh Form Filament untuk preview kalkulasi.
     */
    public function calculateTotals(
        float $subtotal,
        float $discountPercentage = 0,
        float $ppnPercentage = 0,
        float $pphPercentage = 0,
    ): array {
        $discountPercentage = min(max($discountPercentage, 0), 100);
        $ppnPercentage = min(max($ppnPercentage, 0), 100);
        $pphPercentage = min(max($pphPercentage, 0),  100);

        $discountAmount =  $subtotal * ($discountPercentage / 100);
        $dppAmount = max($subtotal - $discountAmount, 0);
        $ppnAmount = $dppAmount * ($ppnPercentage / 100);
        $pphAmount =  $dppAmount * ($pphPercentage / 100);
        $totalAmount = $dppAmount + $ppnAmount;

        $netAmount = max($totalAmount - $pphAmount, 0);

        return [
            'subtotal' => round($subtotal, 2),
            'discount_percentage' => round($discountPercentage, 2),
            'discount_amount' => round($discountAmount,  2),
            'dpp_amount' => round($dppAmount, 2),
            'ppn_percentage' => round($ppnPercentage, 2),
            'ppn_amount' => round($ppnAmount, 2),
            'pph_percentage' => round($pphPercentage, 2),
            'pph_amount' => round($pphAmount, 2),
            'total_amount' => round($totalAmount, 2),
            'net_amount' => round($netAmount,  2),
        ];
    }
}
