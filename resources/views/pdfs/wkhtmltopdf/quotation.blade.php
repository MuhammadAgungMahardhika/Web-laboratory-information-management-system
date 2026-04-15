<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Penawaran - {{ $quotation->quotation_number }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #333;
        }

        /* Setiap halaman cukup page-break, tidak perlu margin besar */
        .page {
            page-break-after: always;
            padding: 5px 0;
        }

        .page:last-child {
            page-break-after: auto;
        }

        /* Header Info */
        .header-info {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .header-info td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .header-info td:first-child,
        .header-info td:nth-child(3) {
            width: 15%;
            font-weight: bold;
        }

        .greeting {
            margin: 10px 0;
            font-weight: bold;
        }

        .intro-text {
            text-align: justify;
            margin-bottom: 10px;
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
            margin-top: 30px;
            font-size: 8.5pt;
        }

        /* Signature Page 1 */
        .signature-container {
            width: 100%;
            text-align: right;
            margin-top: 40px;
        }

        .signature-page1 {
            display: inline-block;
            text-align: left;
        }

        .signature-page1 p {
            margin: 3px 0;
        }

        .signature-box-page1 {
            height: 55px;
            width: 150px;
            margin: 10px 0;
            border-bottom: 1px solid #000;
        }

        /* Section Title */
        .section-title {
            background-color: #333;
            color: white;
            padding: 6px;
            font-weight: bold;
            font-size: 8pt;
            text-align: center;
            margin: 10px 0;
        }

        /* Items Table */
        .table-wrapper {
            width: 100%;
            margin: 10px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6pt;
            table-layout: fixed;
            word-wrap: break-word;
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
        }

        .items-table .section-header {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .col-no {
            width: 25px;
        }

        .col-name {
            width: 120px;
        }

        .col-reg {
            width: 80px;
        }

        .col-param {
            width: 180px;
        }

        .col-qty {
            width: 35px;
        }

        .col-unit {
            width: 45px;
        }

        .col-freq {
            width: 35px;
        }

        .col-price {
            width: 70px;
        }

        .col-total {
            width: 80px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Summary */
        .summary-section {
            margin-top: 10px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .summary-table td {
            padding: 4px;
            border: 1px solid #333;
        }

        .summary-table .label {
            background-color: #f2f2f2;
            font-weight: bold;
            width: 70%;
        }

        .summary-table .value {
            text-align: right;
            font-weight: bold;
            width: 30%;
        }

        .summary-table .total-row td {
            background-color: #e6f7ff;
            font-weight: bold;
        }

        .terbilang {
            font-style: italic;
            font-weight: bold;
            margin: 8px 0;
            font-size: 8pt;
        }

        /* Signature Page 2 - avoid break di tengah */
        .signature-section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            table-layout: fixed;
        }

        .signature-table td {
            width: 50%;
            vertical-align: top;
            padding: 8px 12px;
            border-right: 1px solid #000;
        }

        .signature-table td:last-child {
            border-right: none;
        }

        .signature-box {
            border-bottom: 1px solid #000;
            height: 70px;
            position: relative;
            margin: 0;
        }

        .signature-box .placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 7.5pt;
            color: #aaa;
            white-space: nowrap;
        }

        .signature-table strong {
            font-size: 9pt;
        }

        .signature-table p {
            font-size: 8pt;
            margin: 2px 0;
        }

        .signature-table .name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 8pt;
            margin-top: 5px;
        }

        .signature-table .position {
            font-size: 8pt;
        }

        /* Policy */
        .policy-section {
            margin-top: 5px;
        }

        .policy-title {
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0 5px 0;
            font-size: 8.5pt;
        }

        .policy-section ol {
            margin-left: 15px;
            font-size: 7.5pt;
            line-height: 1.5;
        }

        .policy-section li {
            margin-bottom: 4px;
        }

        .bank-info {
            border: 1px solid #333;
            padding: 6px;
            margin-top: 8px;
            font-size: 7.5pt;
        }

        .bank-row {
            margin-bottom: 3px;
        }

        .bank-label {
            font-weight: bold;
            display: inline-block;
            min-width: 130px;
        }

        .footer-note {
            margin-top: 15px;
            font-size: 7pt;
            font-style: italic;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }

        @page {
            size: A4;
        }
    </style>
</head>

<body>

    {{-- ==============================
         HALAMAN 1: Surat Pengantar
         ============================== --}}
    <div class="page">

        <table class="header-info">
            <tr>
                <td><strong>PIC</strong></td>
                <td>: {{ $quotation->personel->fullname ?? '-' }}</td>
                <td><strong>Tanggal</strong></td>
                <td>: {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Telp</strong></td>
                <td>: {{ $quotation->personel->phone_number ?? '-' }}</td>
                <td><strong>Reff</strong></td>
                <td>: {{ $quotation->quotation_number ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td colspan="3">: {{ $quotation->personel->email ?? '-' }}</td>
            </tr>
        </table>

        <div class="greeting">Dengan Hormat;</div>

        <div class="intro-text">
            Terima kasih sudah memberi kepercayaan kepada {{ $company->name ?? 'Laboratorium Kami' }}.
            Menindaklanjuti permintaan dari <strong>{{ $quotation->customer->name ?? '-' }}</strong>
            perihal {{ $quotation->quotation_name ?? 'pengujian laboratorium' }},
            maka harga yang kami tawarkan adalah sebesar
            <span class="price-highlight">
                Rp
                @php
                    $totalHarga =
                        $quotation->total_price -
                        ($quotation->total_price * ($quotation->discount_percentage ?? 0)) / 100 +
                        ($quotation->total_price * ($quotation->ppn_percentage ?? 0)) / 100 -
                        ($quotation->total_price * ($quotation->pph_percentage ?? 0)) / 100;
                @endphp
                {{ number_format($totalHarga, 0, ',', '.') }},-
            </span>
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

        <div class="signature-container">
            <div class="signature-page1">
                <p><strong>Hormat Kami,</strong></p>
                <p><strong>{{ $company->name ?? 'Laboratorium' }}</strong></p>
                <div class="signature-box-page1"></div>
                <p><strong><u>{{ $quotation->personel->fullname ?? 'Nama Personil' }}</u></strong></p>
                <p>{{ $quotation->personel->position->name ?? 'Marketing' }}</p>
            </div>
        </div>

    </div>

    {{-- ==============================
         HALAMAN 2: Detail Penawaran
         ============================== --}}
    <div class="page">

        <div class="section-title">
            DAFTAR RINCIAN, JUMLAH DAN HARGA BARANG/PEKERJAAN<br>
            {{ strtoupper($quotation->quotation_name ?? 'PENAWARAN') }}
        </div>

        <div class="table-wrapper">
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

                        <tr style="background-color: #f0f0f0;">
                            <td colspan="8" class="text-right"><strong>Sub Total {{ $group }}</strong></td>
                            <td class="text-right"><strong>{{ number_format($groupSubtotal, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Summary --}}
        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td class="label">Total A+B</td>
                    <td class="value">Rp {{ number_format($grandSubtotal, 0, ',', '.') }}</td>
                </tr>
                @if ($quotation->ppn_percentage > 0)
                    <tr>
                        <td class="label">PPN ({{ number_format($quotation->ppn_percentage, 0) }}%)</td>
                        <td class="value">Rp
                            {{ number_format($grandSubtotal * ($quotation->ppn_percentage / 100), 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if ($quotation->pph_percentage > 0)
                    <tr>
                        <td class="label">PPH 23 ({{ number_format($quotation->pph_percentage, 0) }}%)</td>
                        <td class="value">Rp
                            {{ number_format($grandSubtotal * ($quotation->pph_percentage / 100), 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td class="label">TOTAL</td>
                    <td class="value">
                        Rp
                        {{ number_format(
                            $grandSubtotal -
                                ($grandSubtotal * ($quotation->discount_percentage ?? 0)) / 100 +
                                ($grandSubtotal * ($quotation->ppn_percentage ?? 0)) / 100 -
                                ($grandSubtotal * ($quotation->pph_percentage ?? 0)) / 100,
                            0,
                            ',',
                            '.',
                        ) }}
                    </td>
                </tr>
            </table>

            <div class="terbilang">
                Terbilang: {{ $quotation->total_in_words ?? '-' }}
            </div>
        </div>

        {{-- Tanda Tangan --}}
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <strong>Persetujuan biaya yang kami tawarkan</strong>
                        <div class="signature-box">
                            <span class="placeholder">Tanda tangan &amp; cap perusahaan</span>
                        </div>
                        <p>Nama &nbsp;&nbsp;: ........................</p>
                        <p>Jabatan: ........................</p>
                    </td>
                    <td>
                        <strong>Hormat Kami</strong><br>
                        <strong>{{ $company->name ?? 'PT. Nama Perusahaan' }}</strong>
                        <div class="signature-box"></div>
                        <p class="name">{{ $quotation->personel->fullname ?? 'Nama Personil' }}</p>
                        <p class="position">{{ $quotation->personel->position->name ?? 'Marketing' }}</p>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    {{-- ==============================
         HALAMAN 3: Syarat & Ketentuan
         ============================== --}}
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
                    <li>Jangka waktu analisis adalah 10 (sepuluh) hari kerja untuk parameter rutin dan 16 (enam belas)
                        hari kerja untuk parameter subkontrak, kecuali tanah;</li>
                    <li>Untuk permintaan analisis ulang (re-analisis) akan dikenakan biaya lagi sesuai harga analisis
                        dengan ketentuan bahwa sampel tersebut masih cukup untuk dianalisis ulang;</li>
                    <li>Laporan hasil analisis akan dikirim melalui email (sebagai draft), sedangkan hasil analisis asli
                        akan dikirimkan bersamaan dengan tagihan;</li>
                    <li>{{ $company->name ?? 'Laboratorium' }} akan mengeluarkan laporan akhir dari hasil pengujian
                        berupa Laporan Hasil Pengujian (LHP) berdasarkan atas semua informasi yang diberikan. Untuk itu
                        pihak pelanggan diminta untuk meyakinkan bahwa semua informasi yang diberikan sudah sah dan
                        benar; dan</li>
                    <li>Bagi pelanggan yang tidak menerbitkan Purchase Order (PO) atau Surat Perintah Kerja (SPK) dapat
                        menanda tangani penawaran ini dan mengirimkannya kembali melalui alamat email
                        {{ $company->name ?? 'Laboratorium' }}.</li>
                </ol>

                <div class="policy-title">Syarat Pembayaran</div>
                <ol>
                    <li>Untuk nominal tagihan di atas Rp10.000.000,00 wajib membayarkan DP sebesar 50% sebelum kegiatan
                        dilaksanakan;</li>
                    <li>Pembayaran dilakukan sebelum hasil analisa diterima; dan</li>
                    <li>Pembayaran dilakukan secara transfer ke Rekening {{ $company->name ?? 'Perusahaan' }}; yaitu
                    </li>
                </ol>

                <div class="bank-info">
                    <div class="bank-row">
                        <span class="bank-label"><strong>Nama Bank</strong></span>
                        <span>: {{ $company->bank_name ?? 'Bank BNI' }}</span>
                    </div>
                    <div class="bank-row">
                        <span class="bank-label"><strong>Nomor Rekening Giro</strong></span>
                        <span>: {{ $company->bank_account_number ?? '-' }}</span>
                    </div>
                    <div class="bank-row">
                        <span class="bank-label"><strong>Nama</strong></span>
                        <span>: {{ $company->bank_account_name ?? strtoupper($company->name ?? '') }}</span>
                    </div>
                </div>
            @endif

            <div style="text-align: center; margin-top: 20px; font-size: 8pt;">
                <p>-------End-------</p>
            </div>

            <div class="footer-note">
                <p><em>Untuk informasi Sertifikat Akreditasi Laboratorium, Ruang Lingkup Akreditasi,</em></p>
                <p><em>Registrasi KLHK, SKP PJK3, serta Company Profile {{ $company->name ?? 'Laboratorium' }}</em></p>
                <p><em>dapat menghubungi kami atau mengunjungi website resmi.</em></p>
                <p style="margin-top: 10px;">&copy; {{ date('Y') }} {{ $company->name ?? 'Laboratorium' }}. Hak
                    Cipta Dilindungi.</p>
            </div>
        </div>
    </div>

</body>

</html>
