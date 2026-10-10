<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>
        Invoice - {{ $invoice->code }}
    </title>

    <style>
        /* JANGAN pakai "* { margin:0; padding:0 }" -> DomPDF jadi mengabaikan @page margin */
        * {
            box-sizing: border-box;
        }

        body,
        div,
        p,
        table,
        tr,
        td,
        th,
        img,
        strong,
        span {
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

        /* Margin halaman = ruang untuk header & footer di SETIAP halaman */
        @page {
            size: A4 portrait;
            margin: 95px 50px 62px 50px;
        }

        /* ===================== HEADER ===================== */

        .header-fixed {
            position: fixed;
            top: -88px;
            left: 0;
            right: 0;
            background: white;
        }

        .kop-surat {
            width: 100%;
            max-width: 100%;
            display: block;
        }

        /* ===================== FOOTER ===================== */

        .footer-fixed {
            position: fixed;
            bottom: -58px;
            left: 0;
            right: 0;
            height: 44px;
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

        /* ===================== PAGE ===================== */

        .page {
            margin: 0;
        }

        /* ===================== TITLE ===================== */

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

        /* ===================== INFO (1 tabel, 7 kolom) ===================== */

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .info-table td {
            vertical-align: top;
            padding: 2px 3px;
            font-size: 8.5pt;
            line-height: 1.3;
        }

        .info-table td.label {
            font-weight: bold;
            white-space: nowrap;
        }

        .info-table td.box-title {
            font-weight: bold;
            font-size: 9pt;
            padding: 2px 3px 4px 3px;
        }

        /* ===================== ITEMS ===================== */

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 7.5pt;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #333;
            padding: 4px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .items-table thead {
            display: table-header-group;
        }

        .items-table tr {
            page-break-inside: avoid;
        }

        .items-table th {
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* ===================== SUMMARY ===================== */

        .summary-wrapper {
            width: 100%;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-left {
            vertical-align: top;
            padding-right: 10px;
        }

        .summary-right {
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

        .summary-value {
            text-align: right;
            white-space: nowrap;
        }

        .grand-total td {
            font-weight: bold;
            font-size: 9pt;
            border-top: 2px solid #333;
        }

        /* ===================== TERBILANG ===================== */

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

        /* ===================== PAYMENT INFO ===================== */

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

        .payment-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payment-info-table td {
            padding: 1px 2px;
            vertical-align: top;
        }

        .payment-info-table td.label {
            font-weight: bold;
            white-space: nowrap;
        }

        /* ===================== PAYMENT HISTORY ===================== */

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

        /* ===================== STATUS ===================== */

        .status {
            display: inline-block;
            border: 1px solid #333;
            padding: 2px 7px;
            font-weight: bold;
            font-size: 7pt;
        }

        /* ===================== SIGNATURE ===================== */

        .signature-section {
            margin-top: 18px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .signature-table tr {
            page-break-inside: avoid;
        }

        .signature-table td {
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

        /* ===================== NOTES ===================== */

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

        /* ===================== END ===================== */

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

    {{-- ===================== HEADER ===================== --}}

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


    {{-- ===================== FOOTER ===================== --}}

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


    {{-- ===================== MAIN ===================== --}}

    <div class="page">

        {{-- ===================== TITLE ===================== --}}

        <table class="invoice-title">
            <tr>
                <td class="title">INVOICE</td>
            </tr>
            <tr>
                <td class="invoice-code">No. Invoice: {{ $invoice->code }}</td>
            </tr>
        </table>


        {{-- ===================== CUSTOMER & INVOICE INFORMATION ===================== --}}

        @php
            // Dibiarkan sebagai object/null (bukan string '-') agar akses properti aman
            $customer = $invoice->labJob?->quotation?->customer;
            $personel = $invoice->labJob?->quotation?->personel;
        @endphp

        <table class="info-table">
            <tr>
                <td colspan="3" class="box-title">Ditagihkan Kepada:</td>
                <td width="4%"></td>
                <td colspan="3" class="box-title">Informasi Invoice:</td>
            </tr>

            <tr>
                <td class="label" width="9%">Nama</td>
                <td width="2%">:</td>
                <td width="35%">{{ $customer?->name ?? '-' }}</td>
                <td width="4%"></td>
                <td class="label" width="13%">No. Invoice</td>
                <td width="2%">:</td>
                <td width="35%">{{ $invoice->code }}</td>
            </tr>

            <tr>
                <td class="label">Alamat</td>
                <td>:</td>
                <td>{{ $customer?->full_address ?? '-' }}</td>
                <td></td>
                <td class="label">Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($invoice->date)->isoFormat('D MMMM Y') }}</td>
            </tr>

            <tr>
                <td class="label">PIC</td>
                <td>:</td>
                <td>{{ $customer?->contact_person_name ?? '-' }}</td>
                <td></td>
                <td class="label">Jatuh Tempo</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->isoFormat('D MMMM Y') }}</td>
            </tr>

            <tr>
                <td class="label">Telp</td>
                <td>:</td>
                <td>{{ $customer?->contact_phone_number ?? '-' }}</td>
                <td></td>
                <td class="label">Lab Job</td>
                <td>:</td>
                <td>{{ $invoice->labJob?->code ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Email</td>
                <td>:</td>
                <td>{{ $customer?->contact_email ?? '-' }}</td>
                <td></td>
                <td class="label">Status</td>
                <td>:</td>
                <td><span class="status">{{ $invoice->status_enum->label() }}</span></td>
            </tr>
        </table>


        {{-- ===================== ITEMS ===================== --}}

        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="49%">Deskripsi</th>
                    <th width="9%">Qty</th>
                    <th width="18%">Harga Satuan (Rp)</th>
                    <th width="19%">Jumlah (Rp)</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoice->invoiceItems as $index => $item)
                    @php
                        $itemSubtotal =
                            $item->subtotal > 0 ? $item->subtotal : ($item->quantity ?? 0) * ($item->price ?? 0);
                    @endphp

                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $item->description }}</strong></td>
                        <td class="text-center">{{ number_format($item->quantity, 2, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($itemSubtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        {{-- ===================== SUMMARY ===================== --}}

        <div class="summary-wrapper">

            <table class="summary-table">
                <tr>
                    <td class="summary-left" width="55%">
                        <div class="terbilang-box">
                            <div class="terbilang-title">Terbilang:</div>
                            <div class="terbilang-text">
                                {{ rupiahInWords($invoice->net_amount) }}
                            </div>
                        </div>

                        <div class="notes">
                            <div class="notes-title">Catatan:</div>
                            Pembayaran dilakukan sesuai dengan jumlah
                            dan tanggal jatuh tempo yang tercantum
                            pada invoice ini.
                        </div>
                    </td>

                    <td class="summary-right" width="45%">
                        <table class="summary-table-inner">
                            <tr>
                                <td width="55%">Subtotal</td>
                                <td width="45%" class="summary-value">
                                    Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>

                            @if ($invoice->discount_percentage > 0)
                                <tr>
                                    <td>Diskon ({{ number_format($invoice->discount_percentage, 2, ',', '.') }}%)</td>
                                    <td class="summary-value">
                                        - Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td>DPP</td>
                                <td class="summary-value">
                                    Rp {{ number_format($invoice->dpp_amount, 0, ',', '.') }}
                                </td>
                            </tr>

                            @if ($invoice->ppn_percentage > 0)
                                <tr>
                                    <td>PPN ({{ number_format($invoice->ppn_percentage, 2, ',', '.') }}%)</td>
                                    <td class="summary-value">
                                        Rp {{ number_format($invoice->ppn_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif

                            <tr class="grand-total">
                                <td>TOTAL TAGIHAN</td>
                                <td class="summary-value">
                                    Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>

                            @if ($invoice->pph_percentage > 0)
                                <tr>
                                    <td>PPh ({{ number_format($invoice->pph_percentage, 2, ',', '.') }}%)</td>
                                    <td class="summary-value">
                                        - Rp {{ number_format($invoice->pph_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif

                            <tr class="grand-total">
                                <td>TOTAL BERSIH</td>
                                <td class="summary-value">
                                    Rp {{ number_format($invoice->net_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>


        {{-- ===================== PAYMENT HISTORY ===================== --}}

        @if ($invoice->payments->isNotEmpty())
            @php
                $totalPaid = $invoice->payments->sum('amount_paid');
                $remaining = max(0, $invoice->net_amount - $totalPaid);
            @endphp

            <div class="payment-history">
                <div class="payment-history-title">Riwayat Pembayaran</div>

                <table class="payment-table">
                    <thead>
                        <tr>
                            <th width="15%">Tanggal</th>
                            <th width="20%">Kode</th>
                            <th width="20%">Metode</th>
                            <th width="25%">Referensi</th>
                            <th width="20%">Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invoice->payments as $payment)
                            <tr>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($payment->date)->isoFormat('D MMM Y') }}
                                </td>
                                <td>{{ $payment->code }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->reference_number ?? '-' }}</td>
                                <td class="text-right">
                                    Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="4" class="text-right"><strong>Total Dibayar</strong></td>
                            <td class="text-right">
                                <strong>Rp {{ number_format($totalPaid, 0, ',', '.') }}</strong>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-right"><strong>Sisa Tagihan</strong></td>
                            <td class="text-right">
                                <strong>Rp {{ number_format($remaining, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif


        {{-- ===================== BANK INFORMATION ===================== --}}

        <div class="payment-info">

            <div class="payment-title">Informasi Pembayaran</div>

            <table class="payment-info-table">
                <tr>
                    <td class="label" width="22%">Nama Bank</td>
                    <td width="2%">:</td>
                    <td width="76%">{{ $company->bank_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Nomor Rekening</td>
                    <td>:</td>
                    <td>{{ $company->bank_account_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Atas Nama</td>
                    <td>:</td>
                    <td>{{ $company->bank_account_name ?? $company->name }}</td>
                </tr>
            </table>

        </div>


        {{-- ===================== SIGNATURE ===================== --}}

        <div class="signature-section">

            <table class="signature-table">
                <tr>
                    <td class="signature-left" width="50%">
                        <strong>Penerima,</strong>

                        <div class="signature-space"></div>

                        <div>Nama: __________________________</div>
                    </td>

                    <td class="signature-right" width="50%">
                        <strong>Hormat Kami,</strong>
                        <br>
                        <strong>{{ $company->name ?? 'Laboratorium' }}</strong>

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


        {{-- ===================== FOOTER NOTE ===================== --}}

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
