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
     * PAY-{YmdHis}
     *
     * Contoh:
     * PAY-20260907093858
     */
    public function generatePaymentCode(): string
    {
        do {
            $code = 'PAY-' . now()->format('YmdHis');

            // Jika ada kemungkinan dua transaksi
            // dibuat pada detik yang sama.
            $exists = Payment::query()
                ->where('code', $code)
                ->exists();
        } while ($exists);

        return $code;
    }

    /**
     * Generate nomor kuitansi.
     *
     * Nomor hanya dibuat ketika pembayaran
     * sudah Completed.
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

        $count = Payment::query()
            ->whereNotNull('receipt_number')
            ->whereYear('paid_at', $year)
            ->count();

        $sequence = str_pad(
            $count + 1,
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
             * Pastikan jumlah pembayaran
             * tidak melebihi sisa tagihan.
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

                'payment_method' => $data['payment_method'],

                'reference_number' =>
                $data['reference_number'] ?? null,

                'proof' =>
                $data['proof'] ?? null,

                'notes' =>
                $data['notes'] ?? null,

                'status' =>
                $data['status']
                    ?? PaymentStatusEnum::Pending,

                'paid_at' => null,

                'receipt_number' => null,
            ]);
        });
    }

    /**
     * Mengubah status pembayaran.
     *
     * Jika menjadi Completed:
     * - paid_at diisi
     * - nomor kuitansi dibuat
     * - status invoice diperbarui
     */
    public function updateStatus(
        Payment $payment,
        PaymentStatusEnum $status
    ): Payment {
        return DB::transaction(function () use ($payment, $status) {

            /*
             * ==========================================
             * COMPLETED
             * ==========================================
             */
            if ($status === PaymentStatusEnum::Completed) {

                /*
                 * Kalau sebelumnya belum Completed,
                 * validasi jumlah pembayaran.
                 */
                if (
                    $payment->status !==
                    PaymentStatusEnum::Completed
                ) {
                    $this->validatePaymentAmount(
                        invoice: $payment->invoice,
                        amount: (float) $payment->amount_paid,
                        excludePaymentId: $payment->id
                    );
                }

                $payment->status = $status;

                /*
                 * Isi paid_at hanya sekali.
                 */
                $payment->paid_at ??= now();

                /*
                 * Generate kuitansi hanya sekali.
                 */
                $payment->receipt_number ??=
                    $this->generateReceiptNumber();

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
             */

            $payment->status = $status;

            /*
             * Kalau pembayaran tidak Completed,
             * jangan dianggap sebagai pembayaran sah.
             */
            if (
                $status !== PaymentStatusEnum::Completed
            ) {
                $payment->paid_at = null;
                $payment->receipt_number = null;
            }

            $payment->save();

            /*
             * Status invoice ikut dihitung ulang.
             */
            $this->updateInvoiceStatus(
                $payment->invoice
            );

            return $payment->fresh();
        });
    }

    /**
     * Validasi jumlah pembayaran.
     */
    protected function validatePaymentAmount(
        Invoice $invoice,
        float $amount,
        ?int $excludePaymentId = null
    ): void {

        if ($amount <= 0) {
            throw ValidationException::withMessages([
                'amount_paid' =>
                'Jumlah pembayaran harus lebih dari 0.',
            ]);
        }

        $query = $invoice
            ->payments()
            ->where(
                'status',
                PaymentStatusEnum::Completed
            );

        if ($excludePaymentId) {
            $query->where(
                'id',
                '!=',
                $excludePaymentId
            );
        }

        $paidAmount = (float) $query
            ->sum('amount_paid');

        $remainingAmount =
            (float) $invoice->net_amount - $paidAmount;

        if ($amount > $remainingAmount) {
            throw ValidationException::withMessages([
                'amount_paid' =>
                'Jumlah pembayaran melebihi sisa tagihan. '
                    . 'Sisa tagihan: Rp '
                    . number_format(
                        $remainingAmount,
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
                PaymentStatusEnum::Completed
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
     * Update status invoice berdasarkan pembayaran.
     */
    public function updateInvoiceStatus(
        Invoice $invoice
    ): Invoice {

        $totalPaid = $this->getTotalPaid($invoice);

        $netAmount = (float) $invoice->net_amount;

        if ($totalPaid <= 0) {
            $status = InvoiceStatusEnum::Sent;
        } elseif ($totalPaid < $netAmount) {

            $status = InvoiceStatusEnum::PartiallyPaid;
        } else {

            $status = InvoiceStatusEnum::Paid;
        }

        $invoice->update([
            'status' => $status,
        ]);

        return $invoice->fresh();
    }
}
