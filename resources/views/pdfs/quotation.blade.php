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
            overflow-x: hidden;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #333;
        }

        /* Page Break */
        .page {
            page-break-after: always;
            margin: 210px 60px;
            min-height: 100vh;
            position: relative;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .container {
            max-width: 100%;
            margin: 0;
            padding: 0 0 5px 5px;

        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: auto;
            margin: 5px 60px;
            text-align: center;
            z-index: 1000;
        }

        .header img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        .header-quotation-info {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            text-align: center;
            font-size: 10pt;
            padding-bottom: 10px;
            padding-top: 10px;
        }

        .header-quotation-info td {
            padding: 0px;
        }

        .header-quotation-info tr:first-child td {
            background-color: #bedff3;
            /* warna langit biru */
            font-size: 16pt;
            /* lebih besar dari yang lain */
            font-weight: bold;
        }

        /* Fixed Footer */
        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: white;
            z-index: 1000;
            padding: 0px 60px;
            margin: 0;
            display: flex;
        }

        .footer-image {
            width: 90%;
            height: 100%;
        }

        .footer-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .footer-page-number {
            width: 10%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #333;
            font-weight: bold;
            font-size: 12pt;
            background: white;
        }

        /* Header Info */
        .header-info {
            width: 100%;
            border: 2px solid #333;
            /* outline luar */
            border-collapse: collapse;
            font-size: 8pt;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .header-info td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .header-info td:first-child,
        .header-info td:nth-child(3) {
            width: 15%;
            /* label kolom */
            font-weight: bold;
        }

        .info-label {
            font-weight: bold;
            min-width: 50px;
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

        .closing-text {
            margin-top: 30px;
            font-size: 8.5pt;
        }

        /* Signature for Page 1 */
        .signature-container {
            width: 100%;
            text-align: right;
            /* Geser seluruh blok ke kanan */
            margin-top: 40px;
        }

        .signature-page1 {
            display: inline-block;
            /* Supaya lebarnya hanya selebar konten */
            text-align: left;
            /* Isi teks di dalam tetap mulai dari kiri */
        }

        .signature-page1 p {
            margin: 3px 0;
        }

        .signature-box-page1 {
            height: 60px;
            width: 150px;
            margin: 10px 0;
            border-bottom: 1px solid #000;
            /* Garis tanda tangan */
        }

        .section-title {
            background-color: #333;
            color: white;
            padding: 6px;
            font-weight: bold;
            font-size: 8pt;
            text-align: center;
            margin: 10px 0;
        }

        /* Tabel Items */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
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

        /* Signature Page 2 */
        .signature-section {
            margin-top: 20px;
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
            padding: 10px 12px;
            border-right: 1px solid #000;
        }

        .signature-table td:last-child {
            border-right: none;
        }

        .signature-box {
            border-bottom: 1px solid #000;
            box-sizing: border-box;
            height: 100px;
            position: relative;
            margin: 0;
        }

        /* placeholder teks di tengah kotak */
        .signature-box .placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* centra horizontal + vertical */
            margin: 0;
            font-size: 7.5pt;
            color: #666;
            /* warna abu agar terlihat seperti placeholder */
            line-height: 1;
            white-space: nowrap;
            /* jangan pecah baris */
            pointer-events: none;
            /* agar tidak mempengaruhi interaksi */
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
            margin-top: 15px;
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
            line-height: 1.4;
        }


        .policy-section li {
            margin-bottom: 5px;
        }

        .policy-section li p {
            margin: 0;
            display: inline;
        }

        .bank-info {
            border: 1px solid #333;
            padding: 6px;
            margin-top: 8px;
            font-size: 7.5pt;
        }

        .bank-row {
            display: flex;
            margin-bottom: 2px;
        }

        .bank-label {
            font-weight: bold;
            min-width: 120px;
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
            margin: 0.5in;
            size: A4;
        }

        @media print {
            .page {
                padding-top: 0;
                page-break-after: always;
            }

            .header {
                position: relative;
                height: auto;
            }
        }
    </style>

</head>

<body>
    <div class="header">
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
            <img src="{{ $korpBase64 }}" alt="Kop Surat">
        @endif

        <table class="header-quotation-info">
            <tr>
                <td><strong>Quotation Letter </strong></td>
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
    <!-- Fixed Footer - Image 80% + Page Number 20% -->
    <div class="footer-fixed">
        <div class="footer-image">
            @php
                $footerPath = $company->active_setting?->footer_path ?? public_path('images/quotation-footer.png');
                $footerBase64 = '';
                if (file_exists($footerPath)) {
                    $footerData = file_get_contents($footerPath);
                    $footerType = pathinfo($footerPath, PATHINFO_EXTENSION);
                    $footerBase64 = 'data:image/' . $footerType . ';base64,' . base64_encode($footerData);
                }
            @endphp
            @if ($footerBase64)
                <img src="{{ $footerBase64 }}" alt="Footer">
            @endif
        </div>
        <div class="footer-page-number">
            <span class="page-number"></span>
        </div>
    </div>

    <script>
        // Auto page numbering
        document.addEventListener('DOMContentLoaded', function() {
            const pages = document.querySelectorAll('.page');
            const pageNumbers = document.querySelectorAll('.page-number');
            const totalPages = pages.length;

            if (pageNumbers.length > 0) {
                pageNumbers[0].textContent = '1 / ' + totalPages;
            }
        });
    </script>
    <!-- HALAMAN 1: Surat Pengantar -->
    <div class="page">
        <div class="container">
            <!-- Header Info Box -->
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


            <!-- Greeting -->
            <div class="greeting">Dengan Hormat;</div>

            <!-- Introduction -->
            <div class="intro-text">
                Terima kasih sudah memberi kepercayaan kepada {{ $company->name ?? 'Laboratorium Kami' }}.
                Menindaklanjuti permintaan dari <strong>{{ $quotation->customer->name ?? '-' }}</strong>
                perihal {{ $quotation->quotation_name ?? 'pengujian laboratorium' }},
                maka harga yang kami tawarkan adalah sebesar
                <span class="price-highlight">
                    Rp
                    {{ number_format(
                        $quotation->total_price -
                            ($quotation->total_price * ($quotation->discount_percentage ?? 0)) / 100 +
                            ($quotation->total_price * ($quotation->ppn_percentage ?? 0)) / 100 -
                            ($quotation->total_price * ($quotation->pph_percentage ?? 0)) / 100,
                        0,
                        ',',
                        '.',
                    ) }},-
                </span>
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

            <!-- Signature -->
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
    </div>

    <!-- HALAMAN 2: Detail Penawaran -->
    <div class="page">
        <div class="container">
            <!-- Section Title -->
            <div class="section-title">
                DAFTAR RINCIAN, JUMLAH DAN HARGA BARANG/PEKERJAAN<br>
                {{ strtoupper($quotation->quotation_name ?? 'PENAWARAN') }}
            </div>

            <!-- Items Table -->
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
                            {{-- Group Header --}}
                            <tr class="section-header">
                                <td colspan="9"><strong>{{ $groupLabels[$group] ?? $group }}</strong></td>
                            </tr>

                            @php $groupSubtotal = 0; @endphp

                            {{-- Items in Group --}}
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
                                            {{ $item->parameterQuotationItems->pluck('parameter_name')->implode(', ') }}
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

                            {{-- Group Subtotal --}}
                            <tr style="background-color: #f0f0f0;">
                                <td colspan="8" class="text-right"><strong>Sub Total {{ $group }}</strong>
                                </td>
                                <td class="text-right">
                                    <strong>{{ number_format($groupSubtotal, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
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
                                {{ number_format($grandSubtotal * ($quotation->ppn_percentage / 100), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif
                    @if ($quotation->pph_percentage > 0)
                        <tr>
                            <td class="label">PPH 23 ({{ number_format($quotation->pph_percentage, 0) }}%)</td>
                            <td class="value">Rp
                                {{ number_format($grandSubtotal * ($quotation->pph_percentage / 100), 0, ',', '.') }}
                            </td>
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
                    Terbilang:
                    {{ $quotation->total_in_words ?? 'Tujuh puluh enam juta seratus sembilan puluh satu ribu rupiah' }}
                </div>
            </div>

            <!-- Signature -->
            <div class="signature-section">
                <table class="signature-table">
                    <tr>
                        <!-- Kolom Kiri -->
                        <td>
                            <strong>Persetujuan biaya yang kami tawarkan</strong>
                            <div class="signature-box">
                                <p class="placeholder">Tanda tangan & cap perusahaan</p>
                            </div>
                            <p>Nama: ........................</p>
                            <p>Jabatan: ........................</p>
                        </td>
                        <!-- Kolom Kanan -->
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

    </div>

    <!-- HALAMAN 3: Syarat & Ketentuan -->
    <div class="page">
        <div class="container">
            <!-- Policy -->
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
                            belas)
                            hari kerja untuk parameter subkontrak, kecuali tanah;</li>
                        <li>Untuk permintaan analisis ulang (re-analisis) akan dikenakan biaya lagi sesuai harga
                            analisis
                            dengan ketentuan bahwa sampel tersebut masih cukup untuk dianalisis ulang;</li>
                        <li>Laporan hasil analisis akan dikirim melalui email (sebagai draft), sedangkan hasil analisis
                            asli
                            akan dikirimkan bersamaan dengan tagihan;</li>
                        <li>{{ $company->name ?? 'Laboratorium' }} akan mengeluarkan laporan akhir dari hasil pengujian
                            berupa Laporan Hasil Pengujian (LHP) berdasarkan atas semua informasi yang diberikan. Untuk
                            itu
                            pihak pelanggan diminta untuk meyakinkan bahwa semua informasi yang diberikan sudah sah dan
                            benar; dan</li>
                        <li>Bagi pelanggan yang tidak menerbitkan Purchase Order (PO) atau Surat Perintah Kerja (SPK)
                            dapat
                            menanda tangani penawaran ini dan mengirimkannya kembali melalui alamat email
                            {{ $company->name ?? 'Laboratorium' }}.</li>
                    </ol>

                    <div class="policy-title">Syarat Pembayaran</div>
                    <ol>
                        <li>Untuk nominal tagihan di atas Rp10.000.000,00 wajib membayarkan DP sebesar 50% sebelum
                            kegiatan
                            dilaksanakan;</li>
                        <li>Pembayaran dilakukan sebelum hasil analisa diterima; dan</li>
                        <li>Pembayaran dilakukan secara transfer ke Rekening {{ $company->name ?? 'Perusahaan' }};
                            yaitu
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
                            <span>: {{ $company->bank_account_name ?? strtoupper($company->name) }}</span>
                        </div>
                    </div>
                @endif
                <div style="text-align: center; margin-top: 20px; font-size: 8pt;">
                    <p>-------End-------</p>
                </div>

                <div class="footer-note">
                    <p><em>Untuk informasi Sertifikat Akreditasi Laboratorium, Ruang Lingkup Akreditasi,</em></p>
                    <p><em>Registrasi KLHK, SKP PJK3, serta Company Profile {{ $company->name ?? 'Laboratorium' }}</em>
                    </p>
                    <p><em>dapat menghubungi kami atau mengunjungi website resmi.</em></p>
                    <p style="margin-top: 10px;">&copy; {{ date('Y') }} {{ $company->name ?? 'Laboratorium' }}.
                        Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
