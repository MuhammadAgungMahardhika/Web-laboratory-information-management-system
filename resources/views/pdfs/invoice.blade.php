<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>
        Invoice - {{ $invoice->code }}
    </title>

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

        .invoice-title {
            width: 100%;

            border: 2px solid #333;

            border-collapse: collapse;

            text-align: center;

            margin-bottom: 10px;
        }

        .invoice-title td {
            padding: 5px;
        }

        .invoice-title .title {
            background-color: #bedff3;

            font-size: 16pt;

            font-weight: bold;
        }

        .invoice-title .invoice-code {
            font-size: 9pt;
            font-weight: bold;
        }

        /* =====================================================
           CUSTOMER / INVOICE INFO
        ===================================================== */

        .info-wrapper {
            width: 100%;
            margin-bottom: 12px;
        }

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

        .invoice-box {
            width: 45%;
            vertical-align: top;
        }

        .box-title {
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 9pt;
        }

        /* =====================================================
           ITEMS
        ===================================================== */

        .items-table {
            width: 100%;
            border-collapse: collapse;

            table-layout: fixed;

            margin-top: 8px;

            font-size: 7.5pt;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #333;

            padding: 4px;

            vertical-align: top;

            word-break: break-word;
        }

        .items-table th {
            background-color: #e8e8e8;

            font-weight: bold;

            text-align: center;
        }

        .col-no {
            width: 5%;
            text-align: center;
        }

        .col-description {
            width: 49%;
        }

        .col-qty {
            width: 9%;
            text-align: center;
        }

        .col-price {
            width: 18%;
            text-align: right;
        }

        .col-total {
            width: 19%;
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
           PAYMENT INFO
        ===================================================== */

        .payment-info {
            border: 1px solid #333;

            padding: 7px;

            margin-top: 10px;

            page-break-inside: avoid;
        }

        .payment-title {
            font-weight: bold;

            margin-bottom: 5px;

            font-size: 9pt;
        }

        .payment-row {
            display: table;

            width: 100%;

            margin-bottom: 2px;
        }

        .payment-label {
            display: table-cell;

            width: 120px;

            font-weight: bold;
        }

        .payment-value {
            display: table-cell;
        }

        /* =====================================================
           PAYMENT HISTORY
        ===================================================== */

        .payment-history {
            margin-top: 10px;

            page-break-inside: avoid;
        }

        .payment-history-title {
            font-weight: bold;

            margin-bottom: 5px;
        }

        .payment-table {
            width: 100%;

            border-collapse: collapse;

            font-size: 7.5pt;
        }

        .payment-table th,
        .payment-table td {
            border: 1px solid #333;

            padding: 4px;
        }

        .payment-table th {
            background-color: #e8e8e8;

            text-align: center;
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

        <table class="invoice-title">

            <tr>
                <td class="title">
                    INVOICE
                </td>
            </tr>

            <tr>
                <td class="invoice-code">
                    No. Invoice: {{ $invoice->code }}
                </td>
            </tr>

        </table>


        {{-- =================================================
             CUSTOMER & INVOICE INFORMATION
        ================================================== --}}

        @php
            $customer = $invoice->labJob?->quotation?->customer ?? '-';
            $personel = $invoice->labJob?->quotation?->personel?->fullname ?? '-';
        @endphp

        <table class="info-table">
            <tr>
                <td class="customer-box">
                    <div class="box-title">Ditagihkan Kepada:</div>
                    <table class="info-table">
                        <tr>
                            <td class="label">Nama</td>
                            <td class="separator">:</td>
                            <td>{{ $customer?->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Alamat</td>
                            <td class="separator">:</td>
                            <td>{{ $customer?->full_address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">PIC</td>
                            <td class="separator">:</td>
                            <td>{{ $customer->contact_person_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Telp</td>
                            <td class="separator">:</td>
                            <td>{{ $customer->contact_phone_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Email</td>
                            <td class="separator">:</td>
                            <td>{{ $customer->contact_email ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td class="invoice-box">
                    <div class="box-title">
                        Informasi Invoice:
                    </div>
                    <table class="info-table">
                        <tr>
                            <td class="label">No. Invoice</td>
                            <td class="separator">:</td>
                            <td>{{ $invoice->code }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal</td>
                            <td class="separator">:</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->date)->isoFormat('D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jatuh Tempo</td>
                            <td class="separator">:</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->due_date)->isoFormat('D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Lab Job</td>
                            <td class="separator">:</td>
                            <td>{{ $invoice->labJob?->code ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="label">Status</td>
                            <td class="separator">:</td>
                            <td> <span class="status"> {{ $invoice->status_enum->label() }}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- =================================================
             ITEMS
        ================================================== --}}
        <table class="items-table">
            <colgroup>
                <col class="col-no">
                <col class="col-description">
                <col class="col-qty">
                <col class="col-price">
                <col class="col-total">
            </colgroup>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Deskripsi</th>
                    <th>Qty</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($invoice->invoiceItems as $index => $item)
                    @php
                        $itemSubtotal =
                            $item->subtotal > 0 ? $item->subtotal : ($item->quantity ?? 0) * ($item->price ?? 0);
                    @endphp

                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>

                            <strong>
                                {{ $item->description }}
                            </strong>

                        </td>

                        <td class="text-center">
                            {{ number_format($item->quantity, 2, ',', '.') }}
                        </td>

                        <td class="text-right">
                            {{ number_format($item->price, 0, ',', '.') }}
                        </td>

                        <td class="text-right">
                            {{ number_format($itemSubtotal, 0, ',', '.') }}
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>


        {{-- =================================================
             SUMMARY
        ================================================== --}}

        <div class="summary-wrapper">

            <table class="summary-table">
                <tr>
                    <td class="summary-left">
                        <div class="terbilang-box">
                            <div class="terbilang-title">
                                Terbilang:
                            </div>
                            <div class="terbilang-text">
                                {{ rupiahInWords($invoice->net_amount) }}
                            </div>
                        </div>
                        <div class="notes">
                            <div class="notes-title">
                                Catatan:
                            </div>
                            Pembayaran dilakukan sesuai dengan jumlah
                            dan tanggal jatuh tempo yang tercantum
                            pada invoice ini.
                        </div>
                    </td>
                    <td class="summary-right">
                        <table class="summary-table-inner">
                            <tr>
                                <td class="summary-label">
                                    Subtotal
                                </td>
                                <td class="summary-value">
                                    Rp
                                    {{ number_format($invoice->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @if ($invoice->discount_percentage > 0)
                                <tr>
                                    <td class="summary-label">Diskon
                                        ({{ number_format($invoice->discount_percentage, 2, ',', '.') }}%)</td>
                                    <td class="summary-value">- Rp
                                        {{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="summary-label">DPP</td>
                                <td class="summary-value">Rp {{ number_format($invoice->dpp_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @if ($invoice->ppn_percentage > 0)
                                <tr>
                                    <td class="summary-label">PPN
                                        ({{ number_format($invoice->ppn_percentage, 2, ',', '.') }}%)</td>
                                    <td class="summary-value">Rp {{ number_format($invoice->ppn_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif
                            <tr class="grand-total">
                                <td class="summary-label">TOTAL TAGIHAN</td>
                                <td class="summary-value">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}

                                </td>

                            </tr>


                            @if ($invoice->pph_percentage > 0)
                                <tr>

                                    <td class="summary-label">

                                        PPh
                                        ({{ number_format($invoice->pph_percentage, 2, ',', '.') }}%)

                                    </td>

                                    <td class="summary-value">

                                        - Rp
                                        {{ number_format($invoice->pph_amount, 0, ',', '.') }}

                                    </td>

                                </tr>
                            @endif


                            <tr class="grand-total">

                                <td class="summary-label">
                                    TOTAL BERSIH
                                </td>

                                <td class="summary-value">

                                    Rp
                                    {{ number_format($invoice->net_amount, 0, ',', '.') }}

                                </td>

                            </tr>

                        </table>

                    </td>

                </tr>

            </table>

        </div>


        {{-- =================================================
             PAYMENT HISTORY
        ================================================== --}}
        @if ($invoice->payments->isNotEmpty())
            @php
                $totalPaid = $invoice->payments->sum('amount_paid');
                $remaining = max(0, $invoice->net_amount - $totalPaid);
            @endphp

            <div class="payment-history">
                <div class="payment-history-title">
                    Riwayat Pembayaran
                </div>
                <table class="payment-table">
                    <thead>
                        <tr>
                            <th width="15%">
                                Tanggal
                            </th>
                            <th width="20%">
                                Kode
                            </th>
                            <th width="20%">
                                Metode
                            </th>
                            <th width="25%">
                                Referensi
                            </th>

                            <th width="20%">
                                Jumlah
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($invoice->payments as $payment)
                            <tr>

                                <td class="text-center">

                                    {{ \Carbon\Carbon::parse($payment->date)->isoFormat('D MMM Y') }}

                                </td>

                                <td>
                                    {{ $payment->code }}
                                </td>

                                <td>
                                    {{ $payment->payment_method }}
                                </td>

                                <td>
                                    {{ $payment->reference_number ?? '-' }}
                                </td>

                                <td class="text-right">

                                    Rp
                                    {{ number_format($payment->amount_paid, 0, ',', '.') }}

                                </td>

                            </tr>
                        @endforeach

                        <tr>

                            <td colspan="4" class="text-right">
                                <strong>
                                    Total Dibayar
                                </strong>
                            </td>

                            <td class="text-right">

                                <strong>

                                    Rp
                                    {{ number_format($totalPaid, 0, ',', '.') }}

                                </strong>

                            </td>

                        </tr>

                        <tr>

                            <td colspan="4" class="text-right">
                                <strong>
                                    Sisa Tagihan
                                </strong>
                            </td>

                            <td class="text-right">

                                <strong>

                                    Rp
                                    {{ number_format($remaining, 0, ',', '.') }}

                                </strong>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        @endif


        {{-- =================================================
             BANK INFORMATION
        ================================================== --}}

        <div class="payment-info">

            <div class="payment-title">
                Informasi Pembayaran
            </div>

            <div class="payment-row">

                <span class="payment-label">
                    Nama Bank
                </span>

                <span class="payment-value">
                    : {{ $company->bank_name ?? '-' }}
                </span>

            </div>

            <div class="payment-row">

                <span class="payment-label">
                    Nomor Rekening
                </span>

                <span class="payment-value">
                    : {{ $company->bank_account_number ?? '-' }}
                </span>

            </div>

            <div class="payment-row">

                <span class="payment-label">
                    Atas Nama
                </span>

                <span class="payment-value">
                    : {{ $company->bank_account_name ?? $company->name }}
                </span>

            </div>

        </div>


        {{-- =================================================
             SIGNATURE
        ================================================== --}}

        <div class="signature-section">

            <table class="signature-table">

                <tr>

                    <td class="signature-left">

                        <strong>
                            Penerima,
                        </strong>

                        <div class="signature-space"></div>

                        <div>
                            Nama: __________________________
                        </div>

                    </td>


                    <td class="signature-right">

                        <strong>
                            Hormat Kami,
                        </strong>

                        <br>

                        <strong>
                            {{ $company->name ?? 'Laboratorium' }}
                        </strong>

                        <div class="signature-space"></div>

                        <div class="signature-name">

                            {{ $personel?->fullname ?? '-' }}

                        </div>

                        <div>

                            {{ $personel?->position?->name ?? 'Marketing' }}

                        </div>

                    </td>

                </tr>

            </table>

        </div>


        {{-- =================================================
             FOOTER NOTE
        ================================================== --}}

        <div class="footer-note">

            <p>
                Invoice ini diterbitkan oleh
                {{ $company->name ?? 'Laboratorium' }}.
            </p>

            <p>
                &copy; {{ date('Y') }}
                {{ $company->name ?? 'Laboratorium' }}.
                Hak Cipta Dilindungi.
            </p>

        </div>

    </div>

</body>

</html>
