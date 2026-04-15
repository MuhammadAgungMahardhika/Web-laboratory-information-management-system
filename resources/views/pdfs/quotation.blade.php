<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Penawaran - {{ $quotation->quotation_number }}</title>
    <style>
        /* =============================================
           RESET & BASE
        ============================================= */
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

        /* =============================================
           HEADER FIXED
           - Tinggi header harus TEPAT agar margin-top
             .page tidak tumpang tindih.
           - Ukur total tinggi header Anda (kop + tabel info
             + jarak bawah) lalu sesuaikan margin-top .page
        ============================================= */
        .header-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            z-index: 1000;
            padding: 8px 50px 6px 50px;
            /* border-bottom ringan sebagai pemisah visual */
            border-bottom: 1px solid #ccc;
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

        /* =============================================
           FOOTER FIXED
        ============================================= */
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
            /* DomPDF: display:table lebih reliable daripada flex */
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

        /* counter(page) hanya berfungsi di DomPDF via CSS */
        .footer-page-cell::after {
            content: "Hal " counter(page) " / " counter(pages);
        }

        /* =============================================
           HALAMAN
           margin-top = tinggi header-fixed + sedikit jarak
           margin-bottom = tinggi footer-fixed + sedikit jarak
           CATATAN: Sesuaikan nilai ini jika kop surat Anda
           lebih tinggi/pendek.
        ============================================= */
        .page {
            /* Sesuaikan margin-top dengan tinggi aktual header Anda.
               Rata-rata kop surat tinggi ~160px + tabel info ~65px = ~225px.
               Tambah 10px buffer => 235px */
            margin: 235px 50px 60px 50px;
        }

        /* Trik DomPDF: page-break-after only pada halaman pertama & kedua,
           halaman terakhir biarkan auto */
        .page-break {
            page-break-after: always;
        }

        /* =============================================
           KONTEN HALAMAN 1
        ============================================= */
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

        /* Tanda tangan halaman 1 — rata kanan */
        .signature-p1-wrapper {
            width: 100%;
            margin-top: 30px;
            /* page-break-inside: avoid mencegah terpotong */
            page-break-inside: avoid;
        }

        .signature-p1-inner {
            /* float:right tidak selalu stabil di DomPDF,
               gunakan table dengan cell kosong di kiri */
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

        /* =============================================
           KONTEN HALAMAN 2 — TABEL ITEM
        ============================================= */
        .section-title {
            background-color: #333;
            color: white;
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
            /* table-layout:fixed + word-wrap agar kolom tidak overflow */
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
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: center;
            /* Header tabel TIDAK di-repeat di DomPDF secara default,
               tapi thead akan tetap muncul di halaman baru jika ada */
        }

        /* Lebar kolom */
        .col-no {
            width: 22px;
        }

        .col-name {
            width: 110px;
        }

        .col-reg {
            width: 72px;
        }

        .col-param {
            width: 165px;
        }

        .col-qty {
            width: 28px;
        }

        .col-unit {
            width: 38px;
        }

        .col-freq {
            width: 28px;
        }

        .col-price {
            width: 65px;
        }

        .col-total {
            width: 72px;
        }

        .section-header td {
            background-color: #f0f0f0;
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

        /* =============================================
           SUMMARY & TERBILANG
        ============================================= */
        .summary-section {
            margin-top: 8px;
            /* Cegah summary terpisah dari tabel di atasnya jika masih muat */
            page-break-inside: avoid;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .summary-table td {
            padding: 3px 5px;
            border: 1px solid #333;
        }

        .summary-table .lbl {
            background-color: #f2f2f2;
            font-weight: bold;
            width: 70%;
        }

        .summary-table .val {
            text-align: right;
            font-weight: bold;
            width: 30%;
        }

        .summary-table .total-row td {
            background-color: #d9f0ff;
            font-weight: bold;
        }

        .terbilang {
            font-style: italic;
            font-weight: bold;
            margin: 6px 0;
            font-size: 7.5pt;
        }

        /* =============================================
           TANDA TANGAN HALAMAN 2
           page-break-inside: avoid adalah KUNCI agar
           tidak terpotong ketika item banyak
        ============================================= */
        .signature-section {
            margin-top: 0px;
            page-break-inside: avoid;
            /* Jika tanda tangan tidak muat di halaman ini,
               DomPDF akan pindah ke halaman baru */
            page-break-before: auto;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #333;
            table-layout: fixed;
        }

        .signature-table td {
            width: 50%;
            vertical-align: top;
            padding: 8px 10px;
            border-right: 1px solid #333;
        }

        .signature-table td:last-child {
            border-right: none;
        }

        .sig-box {
            height: 65px;
            border-bottom: 1px solid #000;
            position: relative;
            margin: 6px 0 4px 0;
        }

        .sig-box .placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            /* DomPDF tidak support transform sepenuhnya,
               gunakan pendekatan manual */
            margin-top: -6px;
            margin-left: -60px;
            font-size: 7pt;
            color: #999;
            white-space: nowrap;
        }

        .signature-table strong {
            font-size: 8.5pt;
        }

        .signature-table p {
            font-size: 7.5pt;
            margin: 2px 0;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 7.5pt;
        }

        .sig-position {
            font-size: 7.5pt;
        }

        /* =============================================
           HALAMAN 3 — KEBIJAKAN
        ============================================= */
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
            /* DomPDF: display:flex tidak didukung, gunakan table */
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

        .footer-note {
            margin-top: 15px;
            font-size: 7pt;
            font-style: italic;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }

        .end-marker {
            text-align: center;
            margin-top: 18px;
            font-size: 8pt;
        }

        /* =============================================
           @PAGE — UKURAN KERTAS
        ============================================= */
        @page {
            size: A4 portrait;
            /* margin dikosongkan karena kita atur manual
               via .page div */
            margin: 0;
        }
    </style>
</head>

<body>

    {{-- ================================================
         HEADER FIXED (muncul di setiap halaman)
    ================================================ --}}
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
            <img src="{{ $korpBase64 }}" alt="Kop Surat" class="kop-surat">
        @endif

        <table class="header-quotation-info">
            <tr>
                <td><strong>Quotation Letter</strong></td>
            </tr>
            <tr>
                <td>No.Quo: {{ $quotation->quotation_number }}</td>
            </tr>
            <tr>
                <td><strong>{{ $quotation->customer->name }}</strong></td>
            </tr>
            <tr>
                <td>{{ $quotation->customer->full_address }}</td>
            </tr>
        </table>
    </div>

    {{-- ================================================
         FOOTER FIXED (muncul di setiap halaman)
    ================================================ --}}
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

    {{-- ================================================
         HALAMAN 1 — SURAT PENGANTAR
    ================================================ --}}
    <div class="page page-break">
        {{-- Info PIC & Tanggal --}}
        <table class="header-info">
            <tr>
                <td class="label-col">PIC</td>
                <td>: {{ $quotation->personel->fullname ?? '-' }}</td>
                <td class="label-col">Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($quotation->quotation_date)->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="label-col">Telp</td>
                <td>: {{ $quotation->personel->phone_number ?? '-' }}</td>
                <td class="label-col">Reff</td>
                <td>: {{ $quotation->quotation_number ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Email</td>
                <td colspan="3">: {{ $quotation->personel->email ?? '-' }}</td>
            </tr>
        </table>

        <div class="greeting">Dengan Hormat;</div>

        @php
            $totalHarga =
                $quotation->total_price -
                ($quotation->total_price * ($quotation->discount_percentage ?? 0)) / 100 +
                ($quotation->total_price * ($quotation->ppn_percentage ?? 0)) / 100 -
                ($quotation->total_price * ($quotation->pph_percentage ?? 0)) / 100;
        @endphp

        <div class="intro-text">
            Terima kasih sudah memberi kepercayaan kepada {{ $company->name ?? 'Laboratorium Kami' }}.
            Menindaklanjuti permintaan dari <strong>{{ $quotation->customer->name ?? '-' }}</strong>
            perihal {{ $quotation->quotation_name ?? 'pengujian laboratorium' }},
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

        {{-- Tanda tangan halaman 1 — page-break-inside avoid --}}
        <div class="signature-p1-wrapper">
            <div class="signature-p1-inner">
                <div class="sig-p1-spacer"></div>
                <div class="sig-p1-content">
                    <p><strong>Hormat Kami,</strong></p>
                    <p><strong>{{ $company->name ?? 'Laboratorium' }}</strong></p>
                    <div class="sig-p1-box"></div>
                    <p><strong><u>{{ $quotation->personel->fullname ?? 'Nama Personil' }}</u></strong></p>
                    <p>{{ $quotation->personel->position->name ?? 'Marketing' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================
         HALAMAN 2 — RINCIAN HARGA
         Tidak ada page-break-after paksa di sini,
         biarkan konten mengalir alami. Page break
         ditangani oleh DomPDF otomatis sesuai tinggi konten.
    ================================================ --}}
    <div class="page page-break">
        <div class="section-title">
            DAFTAR RINCIAN, JUMLAH DAN HARGA BARANG/PEKERJAAN<br>
            {{ strtoupper($quotation->quotation_name ?? 'PENAWARAN') }}
        </div>

        @php
            $grandSubtotal = $quotation->total_price;
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
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-name">Nama Pekerjaan</th>
                    <th class="col-reg">Baku Mutu</th>
                    <th class="col-param">Parameter</th>
                    <th class="col-qty">Jml</th>
                    <th class="col-unit">Satuan</th>
                    <th class="col-freq">Frek</th>
                    <th class="col-price">Harga (Rp)</th>
                    <th class="col-total">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedItems as $group => $items)
                    <tr class="section-header">
                        <td colspan="9"><strong>{{ $groupLabels[$group] ?? $group }}</strong></td>
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
                            <td class="text-center">{{ $item->frequency ?? 1 }}</td>
                            <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($itemTotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="subtotal-row">
                        <td colspan="8" class="text-right">
                            <strong>Sub Total {{ $group }}</strong>
                        </td>
                        <td class="text-right">
                            <strong>{{ number_format($groupSubtotal, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary — page-break-inside avoid agar tidak terpotong --}}
        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td class="lbl">Total</td>
                    <td class="val">Rp {{ number_format($grandSubtotal, 0, ',', '.') }}</td>
                </tr>
                @if (($quotation->discount_percentage ?? 0) > 0)
                    @php $discAmount = $grandSubtotal * ($quotation->discount_percentage / 100); @endphp
                    <tr>
                        <td class="lbl">Diskon ({{ number_format($quotation->discount_percentage, 0) }}%)</td>
                        <td class="val">- Rp {{ number_format($discAmount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if (($quotation->ppn_percentage ?? 0) > 0)
                    @php $ppnAmount = $grandSubtotal * ($quotation->ppn_percentage / 100); @endphp
                    <tr>
                        <td class="lbl">PPN ({{ number_format($quotation->ppn_percentage, 0) }}%)</td>
                        <td class="val">Rp {{ number_format($ppnAmount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if (($quotation->pph_percentage ?? 0) > 0)
                    @php $pphAmount = $grandSubtotal * ($quotation->pph_percentage / 100); @endphp
                    <tr>
                        <td class="lbl">PPH 23 ({{ number_format($quotation->pph_percentage, 0) }}%)</td>
                        <td class="val">- Rp {{ number_format($pphAmount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td class="lbl">TOTAL KESELURUHAN</td>
                    <td class="val">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div class="terbilang">
                Terbilang: {{ $quotation->total_in_words ?? rupiahInWords($totalHarga) }}
            </div>
        </div>

        {{-- ================================================
             TANDA TANGAN HALAMAN 2
             page-break-inside: avoid → jika tidak muat di
             halaman ini, DomPDF otomatis pindah ke halaman baru
             dan tanda tangan tampil utuh di sana.
        ================================================ --}}
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <strong>Persetujuan biaya yang kami tawarkan</strong>
                        <div class="sig-box">
                            <p class="placeholder">Tanda tangan &amp; cap perusahaan</p>
                        </div>
                        <p>Nama &nbsp;&nbsp;: ................................</p>
                        <p>Jabatan: ................................</p>
                    </td>
                    <td>
                        <strong>Hormat Kami,</strong><br>
                        <strong>{{ $company->name ?? 'PT. Nama Perusahaan' }}</strong>
                        <div class="sig-box"></div>
                        <p class="sig-name">{{ $quotation->personel->fullname ?? 'Nama Personil' }}</p>
                        <p class="sig-position">{{ $quotation->personel->position->name ?? 'Marketing' }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ================================================
         HALAMAN 3 — KEBIJAKAN & SYARAT PEMBAYARAN
    ================================================ --}}
    <div class="page">
        <div class="policy-section">
            @if ($quotation->additional_description)
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
                    <li>{{ $company->name ?? 'Laboratorium' }} akan mengeluarkan laporan akhir dari hasil pengujian
                        berupa Laporan Hasil Pengujian (LHP) berdasarkan atas semua informasi yang diberikan. Untuk itu
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
                            {{ $company->bank_account_name ?? strtoupper($company->name) }}</span>
                    </div>
                </div>
            @endif

            <div class="end-marker">
                <p>-------End-------</p>
            </div>

            <div class="footer-note">
                <p>Untuk informasi Sertifikat Akreditasi Laboratorium, Ruang Lingkup Akreditasi,</p>
                <p>Registrasi KLHK, SKP PJK3, serta Company Profile {{ $company->name ?? 'Laboratorium' }}</p>
                <p>dapat menghubungi kami atau mengunjungi website resmi.</p>
                <p style="margin-top: 8px;">&copy; {{ date('Y') }} {{ $company->name ?? 'Laboratorium' }}.
                    Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </div>

</body>

</html>
