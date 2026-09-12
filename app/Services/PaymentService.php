<?php

namespace App\Services;

use App\Models\Enums\InvoiceStatusEnum;
use App\Models\Enums\PaymentStatusEnum;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    /**
     * Generate kode pembayaran.
     *
     * Format:
     * PAY-{YmdHisv}
     *
     * Contoh:
     * PAY-20260912181000123
     *
     * Menggunakan millisecond untuk mengurangi
     * kemungkinan kode yang sama.
     */
    public function generatePaymentCode(): string
    {
        do {
            $code = 'PAY-' . now()->format('YmdHisv');

            $exists = Payment::query()
                ->where('code', $code)
                ->exists();

            /*
             * Jika masih sama, beri sedikit perbedaan
             * dengan microtime.
             */
            if ($exists) {
                usleep(1000);
            }
        } while ($exists);

        return $code;
    }

    /**
     * Generate nomor kuitansi.
     *
     * Nomor kuitansi tidak pernah digunakan kembali,
     * walaupun payment/kuitansi kemudian dibatalkan.
     *
     * Format:
     * KWT-{YEAR}-{SEQUENCE}
     *
     * Contoh:
     * KWT-2026-0001
     */
    public function generateReceiptNumber(): string
    {
        $year = now()->year;

        $lastReceipt = Payment::query()
            ->whereNotNull('receipt_number')
            ->where(
                'receipt_number',
                'like',
                "KWT-{$year}-%"
            )
            ->orderByDesc('receipt_number')
            ->lockForUpdate()
            ->value('receipt_number');

        $lastSequence = $lastReceipt
            ? (int) substr(
                $lastReceipt,
                strrpos($lastReceipt, '-') + 1
            )
            : 0;

        $sequence = str_pad(
            $lastSequence + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        return "KWT-{$year}-{$sequence}";
    }

    /**
     * Membuat pembayaran baru.
     *
     * Default status = Pending.
     */
    public function createPayment(
        Invoice $invoice,
        array $data
    ): Payment {
        return DB::transaction(function () use ($invoice, $data) {

            $amount = (float) $data['amount_paid'];

            /*
             * Pastikan jumlah pembayaran valid
             * dan tidak melebihi sisa tagihan.
             */
            $this->validatePaymentAmount(
                invoice: $invoice,
                amount: $amount
            );

            return Payment::create([
                'invoice_id' => $invoice->id,

                'code' => $data['code']
                    ?? $this->generatePaymentCode(),

                'payment_date' => $data['payment_date']
                    ?? now()->toDateString(),

                'amount_paid' => $amount,

                'payment_method' =>
                $data['payment_method'],

                'reference_number' =>
                $data['reference_number'] ?? null,

                'proof' =>
                $data['proof'] ?? null,

                'notes' =>
                $data['notes'] ?? null,

                'status' =>
                $data['status']
                    ?? PaymentStatusEnum::Pending->value,

                'paid_at' => null,

                'receipt_number' => null,
            ]);
        });
    }

    /**
     * Mengubah status pembayaran.
     *
     * Jika menjadi Completed:
     *
     * - Validasi jumlah pembayaran
     * - paid_at diisi
     * - nomor kuitansi dibuat jika belum ada
     * - status invoice diperbarui
     *
     * Jika menjadi Cancelled:
     *
     * - receipt_number TIDAK dihapus
     * - status invoice diperbarui
     */
    public function updateStatus(
        Payment $payment,
        PaymentStatusEnum $status
    ): Payment {
        return DB::transaction(function () use ($payment, $status) {

            /*
             * Pastikan relasi invoice tersedia.
             */
            $payment->loadMissing('invoice');

            /*
             * ==========================================
             * COMPLETED
             * ==========================================
             */
            if ($status === PaymentStatusEnum::Completed) {

                /*
                 * Hanya validasi jika sebelumnya
                 * belum Completed.
                 *
                 * Kalau sudah Completed, jangan
                 * menghitung dirinya sendiri sebagai
                 * pembayaran baru.
                 */
                if (
                    $payment->status
                    !== PaymentStatusEnum::Completed->value
                ) {
                    $this->validatePaymentAmount(
                        invoice: $payment->invoice,
                        amount: (float) $payment->amount_paid,
                        excludePaymentId: $payment->id
                    );
                }

                /*
                 * Ubah status menjadi Completed.
                 */
                $payment->status = $status->value;

                /*
                 * paid_at hanya diisi jika sebelumnya null.
                 */
                $payment->paid_at ??= now();

                /*
                 * Generate kuitansi hanya jika belum punya.
                 *
                 * Kalau payment pernah Completed,
                 * kemudian Cancelled, lalu Completed lagi,
                 * nomor kuitansi lama tetap digunakan.
                 */
                if (empty($payment->receipt_number)) {
                    $payment->receipt_number =
                        $this->generateReceiptNumber();
                }

                $payment->save();

                /*
                 * Update status invoice.
                 */
                $this->updateInvoiceStatus(
                    $payment->invoice
                );

                return $payment->fresh();
            }

            /*
             * ==========================================
             * STATUS LAIN
             * ==========================================
             *
             * Termasuk:
             * Pending
             * Cancelled
             *
             * receipt_number TIDAK dihapus.
             */

            $payment->status = $status->value;

            $payment->save();

            /*
             * Update status invoice berdasarkan
             * pembayaran yang masih Completed.
             */
            $this->updateInvoiceStatus(
                $payment->invoice
            );

            return $payment->fresh();
        });
    }

    /**
     * Validasi jumlah pembayaran.
     *
     * Memastikan:
     * - amount > 0
     * - amount tidak melebihi sisa invoice
     */
    protected function validatePaymentAmount(
        Invoice $invoice,
        float $amount,
        ?int $excludePaymentId = null
    ): void {

        /*
         * Jumlah pembayaran harus lebih dari 0.
         */
        if ($amount <= 0) {
            throw ValidationException::withMessages([
                'amount_paid' =>
                'Jumlah pembayaran harus lebih dari 0.',
            ]);
        }

        /*
         * Ambil hanya pembayaran Completed.
         */
        $query = $invoice
            ->payments()
            ->where(
                'status',
                PaymentStatusEnum::Completed->value
            );

        /*
         * Jika sedang mengubah status payment
         * menjadi Completed, payment tersebut
         * dikeluarkan dari perhitungan.
         */
        if ($excludePaymentId !== null) {
            $query->where(
                'id',
                '!=',
                $excludePaymentId
            );
        }

        $paidAmount = (float) $query
            ->sum('amount_paid');

        $remainingAmount =
            (float) $invoice->net_amount
            - $paidAmount;

        /*
         * Tolak jika pembayaran melebihi
         * sisa tagihan.
         */
        if ($amount > $remainingAmount) {
            throw ValidationException::withMessages([
                'amount_paid' =>
                'Jumlah pembayaran melebihi sisa tagihan. '
                    . 'Sisa tagihan: Rp '
                    . number_format(
                        max($remainingAmount, 0),
                        2,
                        ',',
                        '.'
                    ),
            ]);
        }
    }

    /**
     * Hitung total pembayaran yang sudah Completed.
     */
    public function getTotalPaid(
        Invoice $invoice
    ): float {
        return (float) $invoice
            ->payments()
            ->where(
                'status',
                PaymentStatusEnum::Completed->value
            )
            ->sum('amount_paid');
    }

    /**
     * Hitung sisa pembayaran invoice.
     */
    public function getRemainingAmount(
        Invoice $invoice
    ): float {
        return max(
            (float) $invoice->net_amount
                - $this->getTotalPaid($invoice),
            0
        );
    }

    /**
     * Update status invoice berdasarkan
     * total pembayaran Completed.
     *
     * Logic:
     *
     * 0
     * → Sent
     *
     * < total invoice
     * → PartiallyPaid
     *
     * >= total invoice
     * → Paid
     */
    public function updateInvoiceStatus(
        Invoice $invoice
    ): Invoice {

        $totalPaid = $this->getTotalPaid($invoice);

        $netAmount = (float) $invoice->net_amount;

        if ($totalPaid <= 0) {

            $status =
                InvoiceStatusEnum::Sent->value;
        } elseif ($totalPaid < $netAmount) {

            $status =
                InvoiceStatusEnum::PartiallyPaid->value;
        } else {

            $status =
                InvoiceStatusEnum::Paid->value;
        }

        $invoice->update([
            'status' => $status,
        ]);

        return $invoice->fresh();
    }
}
