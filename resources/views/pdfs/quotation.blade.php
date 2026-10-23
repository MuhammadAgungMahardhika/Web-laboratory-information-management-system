<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Penawaran - {{ $quotation->code }}</title>
    <style>
        /* ================= RESET & BASE ================= */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #333;
        }

        /* ================= HEADER FIXED ================= */
        .header-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            z-index: 1000;
            padding: 8px 50px 6px 50px;
        }

        .header-fixed img.kop-surat {
            max-width: 100%;
            display: block;
            margin-bottom: 5px;
        }

        .header-quotation-info {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            text-align: center;
            font-size: 9.5pt;
        }

        .header-quotation-info td {
            padding: 2px 6px;
        }

        .header-quotation-info tr:first-child td {
            background-color: #bedff3;
            font-size: 14pt;
            font-weight: bold;
            padding: 4px 6px;
        }

        /* ================= FOOTER FIXED ================= */
        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 44px;
            background: white;
            z-index: 1000;
            padding: 0 50px;
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
            white-space: nowrap;
        }

        .footer-page-cell::after {
            content: counter(page);
        }

        /* ================= HALAMAN ================= */
        .page {
            margin: 90px 50px 60px 50px;
        }

        .page-break {
            page-break-after: always;
        }

        /* ================= HALAMAN 1 ================= */
        .header-info {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 8px;
        }

        .header-info td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .header-info td.label-col {
            width: 13%;
            font-weight: bold;
            white-space: nowrap;
        }

        .greeting {
            margin: 8px 0 6px 0;
            font-weight: bold;
        }

        .intro-text {
            text-align: justify;
            margin-bottom: 8px;
            font-size: 8.5pt;
            line-height: 1.5;
        }

        .price-highlight {
            font-weight: bold;
            text-decoration: underline;
        }

        .price-inword {
            font-weight: bold;
        }

        .closing-text {
            margin-top: 20px;
            font-size: 8.5pt;
        }

        .signature-p1-wrapper {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-p1-inner {
            display: table;
            width: 100%;
        }

        .sig-p1-spacer {
            display: table-cell;
            width: 65%;
        }

        .sig-p1-content {
            display: table-cell;
            width: 35%;
            text-align: left;
            vertical-align: top;
        }

        .sig-p1-content p {
            margin: 2px 0;
            font-size: 8.5pt;
        }

        .sig-p1-box {
            height: 55px;
            border-bottom: 1px solid #000;
            margin: 8px 0 4px 0;
        }

        /* ================= HALAMAN 2 — TABEL ITEM ================= */
        .section-title {
            border: transparent;
            padding: 5px 6px;
            font-weight: bold;
            font-size: 8pt;
            text-align: center;
            margin: 0 0 8px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6pt;
            table-layout: fixed;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #333;
            padding: 2px 3px;
            vertical-align: top;
            word-break: break-word;
        }

        .items-table th {
            font-weight: bold;
            text-align: center;
        }

        /* Lebar kolom dipakai bersama oleh tabel rincian & tabel summary
           (total harus 100%) supaya garis vertikal keduanya sejajar. */
        .col-no {
            width: 4%;
            text-align: center;
            white-space: nowrap;
        }

        .col-name {
            width: 19%;
        }

        .col-reg {
            width: 13%;
        }

        .col-param {
            width: 27%;
        }

        .col-qty {
            width: 5%;
        }

        .col-unit {
            width: 7%;
        }

        .col-price {
            width: 11%;
        }

        .col-total {
            width: 14%;
        }

        .section-header td {
            font-weight: bold;
            font-size: 6.5pt;
        }

        .subtotal-row td {
            background-color: #e8e8e8;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* ================= SUMMARY ================= */
        .summary-section {
            margin-top: 0;
            page-break-inside: avoid;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            border: 1px solid #333;
        }

        .summary-table td {
            padding: 3px;
            font-size: 7.5pt;
            border: 1px solid #333;
            vertical-align: middle;
        }

        .summary-table .val {
            text-align: right;
            white-space: nowrap;
        }

        .summary-table .terbilang-cell {
            font-style: italic;
            font-weight: bold;
            font-size: 7.5pt;
        }

        .total-row td {
            font-weight: bold;
        }

        /* ================= TANDA TANGAN HALAMAN 2 ================= */
        .signature-section {
            margin-top: 8px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            line-height: 1.2;
        }

        .signature-table td {
            width: 50%;
            vertical-align: top;
            padding: 4px;
        }

        .client-box {
            border: 1px solid #333;
            padding: 10px;
        }

        .company-box {
            padding-left: 12px;
        }

        /* Tinggi judul disamakan kiri & kanan agar garis tanda tangan sejajar */
        .sig-title {
            height: 29pt;
        }

        .sig-box {
            height: 50px;
            border-bottom: 1px solid #000;
            margin: 6px 0 4px 0;
            position: relative;
        }

        .sig-space {
            height: 50px;
            margin: 6px 0 4px 0;
        }

        .sig-box .placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 6.5pt;
            color: #999;
        }

        .signature-table strong {
            font-size: 8pt;
        }

        .signature-table p {
            font-size: 7pt;
            margin: 1px 0;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 7pt;
            margin-top: 2px;
        }

        .sig-position {
            font-size: 7pt;
        }

        /* ================= HALAMAN 3 — KEBIJAKAN ================= */
        .policy-section {
            margin-top: 5px;
        }

        .policy-title {
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0 4px 0;
            font-size: 8.5pt;
        }

        .policy-section ol {
            margin-left: 18px;
            font-size: 7.5pt;
            line-height: 1.5;
        }

        .policy-section li {
            margin-bottom: 4px;
        }

        .bank-info {
            border: 1px solid #333;
            padding: 6px 8px;
            margin-top: 8px;
            font-size: 7.5pt;
        }

        .bank-row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }

        .bank-label {
            display: table-cell;
            font-weight: bold;
            width: 140px;
            white-space: nowrap;
        }

        .bank-value {
            display: table-cell;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }
    </style>
</head>

<body>

    {{-- ============ PERHITUNGAN & HELPER (satu sumber) ============ --}}
    @php
        // Gambar -> data URI base64 (jpg dinormalisasi ke image/jpeg)
        $toBase64 = function (?string $path): string {
            if (!$path || !file_exists($path)) {
                return '';
            }
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $mime = match ($ext) {
                'jpg', 'jpeg' => 'image/jpeg',
                'svg' => 'image/svg+xml',
                default => 'image/' . $ext,
            };
            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
        };

        $letterheadPath = $company->active_setting?->letterhead_path;
        $korpBase64 = $toBase64(
            $letterheadPath ? public_path("storage/{$letterheadPath}") : public_path('images/korp.jpg'),
        );

        $footerPath = $company->active_setting?->footer_path;
        $footerBase64 = $toBase64(
            $footerPath ? public_path("storage/{$footerPath}") : public_path('images/quotation-footer.png'),
        );

        // Angka summary (dasar PPN & PPH tetap total sebelum diskon, sesuai logika semula)
        $grandSubtotal = $quotation->total_price;
        $discPct = $quotation->discount_percentage ?? 0;
        $ppnPct = $quotation->ppn_percentage ?? 0;
        $pphPct = $quotation->pph_percentage ?? 0;

        $discAmount = $grandSubtotal * ($discPct / 100);
        $ppnAmount = $grandSubtotal * ($ppnPct / 100);
        $pphAmount = $grandSubtotal * ($pphPct / 100);

        $totalHarga = $grandSubtotal - $discAmount + $ppnAmount - $pphAmount;

        // Jumlah baris summary: Total + (diskon/ppn/pph bila ada) + TOTAL KESELURUHAN
        $rowCount = 2 + ($discPct > 0 ? 1 : 0) + ($ppnPct > 0 ? 1 : 0) + ($pphPct > 0 ? 1 : 0);

        $tanggal = \Carbon\Carbon::parse($quotation->date)->isoFormat('D MMMM Y');
    @endphp

    {{-- ============ HEADER FIXED ============ --}}
    <div class="header-fixed">
        @if ($korpBase64)
            <img src="{{ $korpBase64 }}" alt="Kop Surat" class="kop-surat">
        @endif
    </div>

    {{-- ============ FOOTER FIXED ============ --}}
    <div class="footer-fixed">
        <div class="footer-image-cell">
            @if ($footerBase64)
                <img src="{{ $footerBase64 }}" alt="Footer">
            @endif
        </div>
        <div class="footer-page-cell"></div>
    </div>

    {{-- ============ HALAMAN 1 — SURAT PENGANTAR ============ --}}
    <div class="page page-break">
        <table class="header-quotation-info">
            <tr>
                <td><strong>Quotation Letter</strong></td>
            </tr>
            <tr>
                <td>No.Quo: {{ $quotation->code }}</td>
            </tr>
            <tr>
                <td><strong>{{ $quotation->customer->name }}</strong></td>
            </tr>
            <tr>
                <td>{{ $quotation->customer->full_address }}</td>
            </tr>
        </table>

        <table class="header-info">
            <tr>
                <td class="label-col">PIC</td>
                <td>: {{ $quotation->personel->fullname ?? '-' }}</td>
                <td class="label-col">Tanggal</td>
                <td>: {{ $tanggal }}</td>
            </tr>
            <tr>
                <td class="label-col">Telp</td>
                <td>: {{ $quotation->personel->phone_number ?? '-' }}</td>
                <td class="label-col">Reff</td>
                <td>: {{ $quotation->code ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Email</td>
                <td colspan="3">: {{ $quotation->personel->email ?? '-' }}</td>
            </tr>
        </table>

        <div class="greeting">Dengan Hormat;</div>

        <div class="intro-text">
            Terima kasih sudah memberi kepercayaan kepada {{ $company->name ?? 'Laboratorium Kami' }}.
            Menindaklanjuti permintaan dari <strong>{{ $quotation->customer->name ?? '-' }}</strong>
            perihal {{ $quotation->name ?? 'pengujian laboratorium' }},
            maka harga yang kami tawarkan adalah sebesar
            <span class="price-highlight">Rp {{ number_format($totalHarga, 0, ',', '.') }},-</span>
            <span class="price-inword">({{ rupiahInWords($totalHarga) }})</span>
            dengan rincian anggaran biaya selengkapnya pada halaman berikutnya.
        </div>

        <div class="intro-text">
            Apabila ada hal yang perlu ditanyakan terkait penawaran kami ini, dapat menghubungi kami
            di {{ $company->phone ?? '-' }} atau melalui email di: {{ $company->email ?? '-' }}.
        </div>

        <div class="intro-text">
            Selanjutnya, mohon untuk dapat membaca terlebih dahulu dan memahami kebijakan perihal administrasi
            penerimaan contoh uji di halaman terakhir dari penawaran ini. Persetujuan penawaran ini berarti juga
            menyatakan bahwa kebijakan {{ $company->name ?? 'Laboratorium' }} dapat dimengerti dan disetujui.
        </div>

        <div class="closing-text">
            <p>Demikianlah yang dapat kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        </div>

        <div class="signature-p1-wrapper">
            <div class="signature-p1-inner">
                <div class="sig-p1-spacer"></div>
                <div class="sig-p1-content">
                    <p><strong>Hormat Kami,</strong></p>
                    <p><strong>A.n Kepala Laboratorium</strong></p>
                    <div class="sig-p1-box"></div>
                    <p><strong><u>{{ $quotation->personel->fullname ?? 'Nama Personil' }}</u></strong></p>
                    <p>{{ $quotation->personel->position->name ?? 'Marketing' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ HALAMAN 2 — RINCIAN HARGA ============ --}}
    <div class="page page-break">
        <div class="section-title">
            DAFTAR RINCIAN, JUMLAH DAN HARGA JASA/PEKERJAAN<br>
            {{ strtoupper($quotation->name ?? 'PENAWARAN') }}
        </div>

        @php
            $groupedItems = $quotation->quotationItems->groupBy('group');
            $groupLabels = [
                'A' => 'A. Biaya Pengambilan dan Analisis Contoh Uji',
                'B' => 'B. Biaya Operasional',
                'C' => 'C. Biaya Lainnya',
                'D' => 'D. Biaya Tambahan',
                'E' => 'E. Biaya Ekstra',
            ];
            $itemNumber = 1;
        @endphp

        <table class="items-table">
            <colgroup>
                <col class="col-no">
                <col class="col-name">
                <col class="col-reg">
                <col class="col-param">
                <col class="col-qty">
                <col class="col-unit">
                <col class="col-price">
                <col class="col-total">
            </colgroup>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-name">Bahan / Produk Uji</th>
                    <th class="col-reg">Baku Mutu (BML)</th>
                    <th class="col-param">Parameter Uji</th>
                    <th class="col-qty">Jml</th>
                    <th class="col-unit">Satuan</th>
                    <th class="col-price">Harga (Rp)</th>
                    <th class="col-total">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedItems as $group => $items)
                    <tr class="section-header">
                        <td colspan="8"><strong>{{ $groupLabels[$group] ?? $group }}</strong></td>
                    </tr>
                    @php $groupSubtotal = 0; @endphp
                    @foreach ($items as $item)
                        @php
                            $itemTotal = ($item->quantity ?? 0) * $item->price * ($item->frequency ?? 1);
                            $groupSubtotal += $itemTotal;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $itemNumber++ }}</td>
                            <td>
                                <strong>{{ $item->description ?? '-' }}</strong>
                                @if ($item->location)
                                    <br><small>{{ $item->location }}</small>
                                @endif
                            </td>
                            <td>{{ $item->regulation_name ?? '-' }}</td>
                            <td>
                                @if ($item->parameterQuotationItems->isNotEmpty())
                                    {{ $item->parameterQuotationItems->pluck('parameter_code')->implode(', ') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity ?? 0 }}</td>
                            <td class="text-center">{{ $item->unit ?? '-' }}</td>
                            <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($itemTotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="subtotal-row">
                        <td colspan="7" class="text-right">
                            <strong>Sub Total {{ $group }}</strong>
                        </td>
                        <td class="text-right">
                            <strong>{{ number_format($groupSubtotal, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary: colgroup identik dengan tabel rincian agar garis vertikal sejajar --}}
        <div class="summary-section">
            <table class="summary-table">
                <colgroup>
                    <col class="col-no">
                    <col class="col-name">
                    <col class="col-reg">
                    <col class="col-param">
                    <col class="col-qty">
                    <col class="col-unit">
                    <col class="col-price">
                    <col class="col-total">
                </colgroup>

                <tr>
                    {{-- Terbilang: kolom 1-4 (No s/d Parameter) --}}
                    <td colspan="4" rowspan="{{ $rowCount }}" class="terbilang-cell">
                        Terbilang : {{ $quotation->total_in_words ?? rupiahInWords($totalHarga) }}
                    </td>
                    {{-- Label: kolom 5-7 (Jml, Satuan, Harga) --}}
                    <td colspan="3">Total</td>
                    {{-- Nilai: kolom 8, sejajar dengan "Jumlah (Rp)" --}}
                    <td class="val">Rp {{ number_format($grandSubtotal, 0, ',', '.') }}</td>
                </tr>

                @if ($discPct > 0)
                    <tr>
                        <td colspan="3">Diskon ({{ number_format($discPct, 0) }}%)</td>
                        <td class="val">- Rp {{ number_format($discAmount, 0, ',', '.') }}</td>
                    </tr>
                @endif

                @if ($ppnPct > 0)
                    <tr>
                        <td colspan="3">PPN ({{ number_format($ppnPct, 0) }}%)</td>
                        <td class="val">Rp {{ number_format($ppnAmount, 0, ',', '.') }}</td>
                    </tr>
                @endif

                @if ($pphPct > 0)
                    <tr>
                        <td colspan="3">PPH 23 ({{ number_format($pphPct, 0) }}%)</td>
                        <td class="val">- Rp {{ number_format($pphAmount, 0, ',', '.') }}</td>
                    </tr>
                @endif

                <tr class="total-row">
                    <td colspan="3">TOTAL KESELURUHAN</td>
                    <td class="val">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        {{-- Tanda tangan: melekat setelah summary, tidak terpotong antar halaman --}}
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td class="client-box">
                        <div class="sig-title">
                            <strong>Persetujuan biaya yang kami tawarkan</strong>
                        </div>
                        <div class="sig-box">
                            <p class="placeholder">Tanda tangan &amp; cap perusahaan</p>
                        </div>
                        <p>Nama &nbsp;&nbsp;: ...............................</p>
                        <p>Jabatan: ...............................</p>
                    </td>
                    <td class="company-box">
                        <div class="sig-title">
                            {{ $company->city->name ?? 'Jambi' }}, {{ $tanggal }}.<br>
                            Hormat Kami<br>
                            <strong>{{ $company->name ?? 'Jalint Lab' }}</strong>
                        </div>

                        <div class="sig-space"></div>

                        <p class="sig-name">{{ $quotation->personel->fullname ?? 'Nama Personil' }}</p>
                        <p class="sig-position">{{ $quotation->personel->position->name ?? 'Marketing' }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ============ HALAMAN 3 — KEBIJAKAN & SYARAT PEMBAYARAN ============ --}}
    <div class="page">
        <div class="policy-section">
            @if ($quotation->additional_description)
                {{-- Pastikan isi sudah disanitasi di sisi server (mis. HTMLPurifier) --}}
                {!! $quotation->additional_description !!}
            @else
                <div class="policy-title">Kebijakan Administrasi Pengujian</div>
                <ol>
                    <li>Harga yang kami tawarkan berdasarkan jumlah contoh uji yang tertera dan dapat berubah sesuai
                        dengan jumlah yang sebenarnya;</li>
                    <li>Penawaran harga berlaku untuk 1 (satu) bulan;</li>
                    <li>Jangka waktu analisis adalah 10 (sepuluh) hari kerja untuk parameter rutin dan 16 (enam
                        belas) hari kerja untuk parameter subkontrak, kecuali tanah;</li>
                    <li>Untuk permintaan analisis ulang (re-analisis) akan dikenakan biaya lagi sesuai harga analisis
                        dengan ketentuan bahwa sampel tersebut masih cukup untuk dianalisis ulang;</li>
                    <li>Laporan hasil analisis akan dikirim melalui email (sebagai draft), sedangkan hasil analisis
                        asli akan dikirimkan bersamaan dengan tagihan;</li>
                    <li>{{ $company->name ?? 'Laboratorium' }} akan mengeluarkan laporan akhir dari Pengujian
                        berupa Laporan Pengujian (LHP) berdasarkan atas semua informasi yang diberikan. Untuk itu
                        pihak pelanggan diminta untuk meyakinkan bahwa semua informasi yang diberikan sudah sah dan
                        benar; dan</li>
                    <li>Bagi pelanggan yang tidak menerbitkan Purchase Order (PO) atau Surat Perintah Kerja (SPK)
                        dapat menanda tangani penawaran ini dan mengirimkannya kembali melalui alamat email
                        {{ $company->name ?? 'Laboratorium' }}.</li>
                </ol>

                <div class="policy-title">Syarat Pembayaran</div>
                <ol>
                    <li>Untuk nominal tagihan di atas Rp10.000.000,00 wajib membayarkan DP sebesar 50% sebelum
                        kegiatan dilaksanakan;</li>
                    <li>Pembayaran dilakukan sebelum hasil analisa diterima; dan</li>
                    <li>Pembayaran dilakukan secara transfer ke Rekening
                        {{ $company->name ?? 'Perusahaan' }}; yaitu</li>
                </ol>

                <div class="bank-info">
                    <div class="bank-row">
                        <span class="bank-label"><strong>Nama Bank</strong></span>
                        <span class="bank-value">: {{ $company->bank_name ?? 'Bank BNI' }}</span>
                    </div>
                    <div class="bank-row">
                        <span class="bank-label"><strong>Nomor Rekening Giro</strong></span>
                        <span class="bank-value">: {{ $company->bank_account_number ?? '-' }}</span>
                    </div>
                    <div class="bank-row">
                        <span class="bank-label"><strong>Nama</strong></span>
                        <span class="bank-value">:
                            {{ $company->bank_account_name ?? strtoupper($company->name ?? '') }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

</body>

</html>
