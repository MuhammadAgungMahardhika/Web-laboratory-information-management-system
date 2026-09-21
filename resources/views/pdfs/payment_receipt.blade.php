<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Kuitansi - {{ $payment->receipt_number }}</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8.5pt;
            line-height: 1.4;
            color: #333;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .header-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 8px 50px 6px 50px;
            background: white;
            z-index: 1000;
        }

        .kop-surat {
            width: 100%;
            max-width: 100%;
            display: block;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 44px;
            padding: 0 50px;
            background: white;
            border-top: 1px solid #ccc;
            display: table;
            width: 100%;
        }

        .footer-image-cell {
            display: table-cell;
            width: 87%;
            height: 44px;
            vertical-align: middle;
        }

        .footer-image-cell img {
            width: 100%;
            height: 40px;
            object-fit: cover;
            display: block;
        }

        .footer-page-cell {
            display: table-cell;
            width: 13%;
            height: 44px;
            vertical-align: middle;
            text-align: center;
            border: 2px solid #333;
            font-weight: bold;
            font-size: 10pt;
            background: white;
        }

        .footer-page-cell::after {
            content: "Hal " counter(page);
        }

        /* =====================================================
           PAGE
        ===================================================== */

        .page {
            margin: 90px 50px 60px 50px;
        }

        /* =====================================================
           TITLE
        ===================================================== */

        .receipt-title {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            text-align: center;
            margin-bottom: 10px;
        }

        .receipt-title td {
            padding: 5px;
        }

        .receipt-title .title {
            background-color: #bedff3;
            font-size: 16pt;
            font-weight: bold;
        }

        .receipt-title .receipt-code {
            font-size: 9pt;
            font-weight: bold;
        }

        /* =====================================================
           INFO
        ===================================================== */

        .info-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .info-table td {
            vertical-align: top;
            padding: 2px 4px;
        }

        .info-table .label {
            width: 90px;
            font-weight: bold;
            white-space: nowrap;
        }

        .info-table .separator {
            width: 8px;
        }

        .customer-box {
            width: 55%;
            vertical-align: top;
        }

        .receipt-box {
            width: 45%;
            vertical-align: top;
        }

        .box-title {
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 9pt;
        }

        /* =====================================================
           PAYMENT DETAIL
        ===================================================== */

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 8px;
            font-size: 7.5pt;
        }

        .detail-table th,
        .detail-table td {
            border: 1px solid #333;
            padding: 4px;
            vertical-align: top;
            word-break: break-word;
        }

        .detail-table th {
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: center;
        }

        .col-no {
            width: 8%;
            text-align: center;
        }

        .col-description {
            width: 62%;
        }

        .col-total {
            width: 30%;
            text-align: right;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* =====================================================
           SUMMARY
        ===================================================== */

        .summary-wrapper {
            width: 100%;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .summary-left {
            width: 55%;
            vertical-align: top;
            padding-right: 10px;
        }

        .summary-right {
            width: 45%;
            vertical-align: top;
        }

        .summary-table-inner {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table-inner td {
            border: 1px solid #333;
            padding: 4px 6px;
            font-size: 8pt;
        }

        .summary-label {
            width: 58%;
        }

        .summary-value {
            width: 42%;
            text-align: right;
        }

        .grand-total td {
            font-weight: bold;
            font-size: 9pt;
            border-top: 2px solid #333;
        }

        /* =====================================================
           TERBILANG
        ===================================================== */

        .terbilang-box {
            border: 1px solid #333;
            padding: 7px;
            margin-bottom: 8px;
            min-height: 55px;
        }

        .terbilang-title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .terbilang-text {
            font-style: italic;
            font-size: 7.5pt;
        }

        /* =====================================================
           NOTES
        ===================================================== */

        .notes {
            margin-top: 10px;
            border: 1px solid #333;
            padding: 7px;
            font-size: 7.5pt;
            page-break-inside: avoid;
        }

        .notes-title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        /* =====================================================
           STATUS
        ===================================================== */

        .status {
            display: inline-block;
            border: 1px solid #333;
            padding: 2px 7px;
            font-weight: bold;
            font-size: 7pt;
        }

        /* =====================================================
           SIGNATURE
        ===================================================== */

        .signature-section {
            margin-top: 18px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .signature-table td {
            width: 50%;
            vertical-align: top;
            padding: 4px;
        }

        .signature-left {
            padding-right: 20px;
        }

        .signature-right {
            padding-left: 20px;
            text-align: center;
        }

        .signature-space {
            height: 55px;
            border-bottom: 1px solid #000;
            margin: 8px 0 4px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* =====================================================
           END
        ===================================================== */

        .footer-note {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 7pt;
            font-style: italic;
        }

        /* =====================================================
   ATTACHMENT / BUKTI PEMBAYARAN
===================================================== */

        .attachment-page {
            page-break-before: always;
            margin-top: 10px;
        }

        .attachment-box {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
            margin-top: 10px;
        }

        .attachment-image {
            max-width: 100%;
            max-height: 650px;
            width: auto;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: contain;
        }

        .attachment-caption {
            margin-top: 8px;
            font-size: 8pt;
            text-align: center;
            font-style: italic;
            color: #333;
        }
    </style>
</head>

<body>

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="header-fixed">
        @php
            $dynamicKorpPath = $company->active_setting?->letterhead_path;
            $korpPath = $dynamicKorpPath ? public_path("storage/{$dynamicKorpPath}") : public_path('images/korp.jpg');
            $korpBase64 = '';
            if (file_exists($korpPath)) {
                $korpData = file_get_contents($korpPath);
                $korpType = pathinfo($korpPath, PATHINFO_EXTENSION);
                $korpBase64 = 'data:image/' . $korpType . ';base64,' . base64_encode($korpData);
            }
        @endphp
        @if ($korpBase64)
            <img src="{{ $korpBase64 }}" class="kop-surat" alt="Kop Surat">
        @endif
    </div>

    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="footer-fixed">
        <div class="footer-image-cell">
            @php
                $footerImgPath = $company->active_setting?->footer_path
                    ? public_path('storage/' . $company->active_setting->footer_path)
                    : public_path('images/quotation-footer.png');
                $footerBase64 = '';
                if (file_exists($footerImgPath)) {
                    $footerData = file_get_contents($footerImgPath);
                    $footerType = pathinfo($footerImgPath, PATHINFO_EXTENSION);
                    $footerBase64 = 'data:image/' . $footerType . ';base64,' . base64_encode($footerData);
                }
            @endphp
            @if ($footerBase64)
                <img src="{{ $footerBase64 }}" alt="Footer">
            @endif
        </div>
        <div class="footer-page-cell"></div>
    </div>

    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <div class="page">

        {{-- =================================================
             TITLE
        ================================================== --}}

        <table class="receipt-title">
            <tr>
                <td class="title">KUITANSI PEMBAYARAN</td>
            </tr>
            <tr>
                <td class="receipt-code">No. Kuitansi: {{ $payment->receipt_number }}</td>
            </tr>
        </table>

        {{-- =================================================
             CUSTOMER & RECEIPT INFORMATION
        ================================================== --}}

        @php
            $customer = $invoice->labJob?->quotation?->customer ?? '-';
            $paymentMethodLabel = match ($payment->payment_method) {
                'cash' => 'Tunai',
                'qris' => 'QRIS',
                'transfer' => 'Transfer Bank',
                default => 'Lainnya',
            };
        @endphp

        <div class="box-title">Diterima Dari:</div>
        <table class="info-table-flat">
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer?->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer?->full_address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">PIC</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->contact_person_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Telp</td>
                <td class="separator">:</td>
                <td class="value">{{ $customer->contact_phone_number ?? '-' }}</td>
            </tr>
        </table>

        <div class="box-title" style="margin-top: 8px;">Informasi Pembayaran:</div>
        <table class="info-table-flat">
            <tr>
                <td class="label">No. Invoice</td>
                <td class="separator">:</td>
                <td class="value">{{ $invoice->code }}</td>
            </tr>
            <tr>
                <td class="label">Kode Bayar</td>
                <td class="separator">:</td>
                <td class="value">{{ $payment->code }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="separator">:</td>
                <td class="value">{{ \Carbon\Carbon::parse($payment->date)->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="label">Metode</td>
                <td class="separator">:</td>
                <td class="value">{{ $paymentMethodLabel }}</td>
            </tr>
            @if ($payment->reference_number)
                <tr>
                    <td class="label">No. Referensi</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $payment->reference_number }}</td>
                </tr>
            @endif
            <tr>
                <td class="label">Status</td>
                <td class="separator">:</td>
                <td class="value"><span
                        class="status">{{ \App\Models\Enums\PaymentStatusEnum::from($payment->status)->label() }}</span>
                </td>
            </tr>
        </table>

        {{-- =================================================
             PAYMENT DETAIL
        ================================================== --}}

        <table class="detail-table">
            <colgroup>
                <col class="col-no">
                <col class="col-description">
                <col class="col-total">
            </colgroup>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Keterangan</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Pembayaran atas Invoice
                        <strong>{{ $invoice->code }}</strong>{{ $payment->notes ? ' — ' . $payment->notes : '' }}
                    </td>
                    <td class="text-right">{{ number_format($payment->amount_paid, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- =================================================
             SUMMARY
        ================================================== --}}

        @php
            $totalPaidAll = $invoice->payments
                ->where('status', \App\Models\Enums\PaymentStatusEnum::Completed->value)
                ->sum('amount_paid');
            $remaining = max(0, $invoice->net_amount - $totalPaidAll);
        @endphp

        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td class="summary-left">
                        <div class="terbilang-box">
                            <div class="terbilang-title">Terbilang:</div>
                            <div class="terbilang-text">{{ trim(rupiahInWords($payment->amount_paid)) }}</div>
                        </div>
                        @if ($payment->notes)
                            <div class="notes">
                                <div class="notes-title">Catatan:</div>
                                {{ $payment->notes }}
                            </div>
                        @endif
                    </td>

                    <td class="summary-right">
                        <table class="summary-table-inner">
                            <tr>
                                <td class="summary-label">Total Tagihan Invoice</td>
                                <td class="summary-value">Rp {{ number_format($invoice->net_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="summary-label">Total Sudah Dibayar</td>
                                <td class="summary-value">Rp {{ number_format($totalPaidAll, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="grand-total">
                                <td class="summary-label">DIBAYAR SAAT INI</td>
                                <td class="summary-value">Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="grand-total">
                                <td class="summary-label">SISA TAGIHAN</td>
                                <td class="summary-value">Rp {{ number_format($remaining, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        {{-- =================================================
             SIGNATURE
        ================================================== --}}

        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td class="signature-left">
                        <br>
                        <strong>Pembayar,</strong>
                        <div class="signature-space"></div>
                        <div class="signature-name"></div>
                        <div>Jabatan : </div>
                    </td>

                    <td class="signature-right">
                        <strong>Diterima Oleh,</strong>
                        <br>
                        <strong>{{ $company->name ?? 'Laboratorium' }}</strong>
                        <div class="signature-space"></div>
                        <div class="signature-name">{{ $payment->created_by ?? '-' }}</div>
                        <div>Petugas Kasir</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- =================================================
             FOOTER NOTE
        ================================================== --}}

        <div class="footer-note">
            <p>Kuitansi ini diterbitkan oleh {{ $company->name ?? 'Laboratorium' }}.</p>
            <p>&copy; {{ date('Y') }} {{ $company->name ?? 'Laboratorium' }}. Hak Cipta Dilindungi.</p>
        </div>
        {{-- =================================================
             BUKTI PEMBAYARAN (HALAMAN 2)
        ================================================== --}}

        @php
            $attachmentBase64 = null;
            $attachmentIsPdf = false;

            if ($payment->attachment_path) {
                $attachmentFullPath = public_path('storage/' . $payment->attachment_path);

                if (file_exists($attachmentFullPath)) {
                    $attachmentExt = strtolower(pathinfo($attachmentFullPath, PATHINFO_EXTENSION));

                    if (in_array($attachmentExt, ['jpg', 'jpeg', 'png'])) {
                        $mime = $attachmentExt === 'png' ? 'image/png' : 'image/jpeg';
                        $attachmentBase64 =
                            'data:' . $mime . ';base64,' . base64_encode(file_get_contents($attachmentFullPath));
                    } elseif ($attachmentExt === 'pdf') {
                        $attachmentIsPdf = true;
                    }
                }
            }
        @endphp

        @if ($attachmentBase64)
            <div class="attachment-page">
                <table class="receipt-title">
                    <tr>
                        <td class="title" style="font-size: 12pt;">BUKTI PEMBAYARAN</td>
                    </tr>
                    <tr>
                        <td class="receipt-code">No. Kuitansi: {{ $payment->receipt_number }} &nbsp;|&nbsp; Invoice:
                            {{ $invoice->code }}</td>
                    </tr>
                </table>
                <div class="attachment-box">
                    <img src="{{ $attachmentBase64 }}" class="attachment-image" alt="Bukti Pembayaran">
                </div>
                <div class="attachment-caption">Dilampirkan sebagai bukti pembayaran sebesar Rp
                    {{ number_format($payment->amount_paid, 0, ',', '.') }} pada
                    {{ \Carbon\Carbon::parse($payment->date)->isoFormat('D MMMM Y') }}.</div>
            </div>
        @elseif ($attachmentIsPdf)
            <div class="attachment-page">
                <table class="receipt-title">
                    <tr>
                        <td class="title" style="font-size: 12pt;">BUKTI PEMBAYARAN</td>
                    </tr>
                </table>
                <div class="attachment-box">
                    <div class="attachment-caption">Bukti pembayaran dilampirkan dalam berkas PDF terpisah dan tidak
                        dapat ditampilkan di halaman ini.</div>
                </div>
            </div>
        @endif
    </div>

</body>

</html>
