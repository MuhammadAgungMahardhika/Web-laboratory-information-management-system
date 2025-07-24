<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Penawaran - {{ $quotation->quotation_number }}</title>
    <style>
        /* CSS Umum untuk dokumen */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            /* Font umum untuk mendukung berbagai karakter non-Latin */
            font-size: 10pt;
            line-height: 1.6;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Kop Surat (Header) */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .header h1 {
            margin: 0;
            color: #0056b3;
            font-size: 18pt;
        }

        .header p {
            font-size: 9pt;
            color: #666;
            margin: 2px 0;
        }

        .header img {
            max-height: 60px;
            /* Tinggi maksimum logo */
            margin-bottom: 10px;
        }

        /* Judul Dokumen */
        .document-title {
            text-align: center;
            color: #0056b3;
            font-size: 16pt;
            margin-bottom: 25px;
        }

        /* Detail Penawaran & Pelanggan */
        .details-section {
            display: block;
            /* Menggunakan display:block untuk wrapping pada DOMPDF */
            width: 100%;
            margin-bottom: 20px;
        }

        .details-section>div {
            width: 48%;
            /* Hampir setengah, sisakan sedikit margin */
            display: inline-block;
            /* Untuk menempatkan di samping satu sama lain */
            vertical-align: top;
            box-sizing: border-box;
            /* Pastikan padding dihitung dalam lebar */
            padding-right: 1%;
            padding-left: 1%;
            /* Untuk spacing */
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 2px 0;
            vertical-align: top;
            text-align: left;
            font-size: 9pt;
        }

        .details-table .label-col {
            width: 35%;
            /* Lebar untuk label */
            font-weight: bold;
            color: #555;
        }

        /* Paragraf Pendahuluan */
        .intro-text {
            margin-bottom: 20px;
            font-size: 10pt;
        }

        /* Tabel Item Penawaran */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 9pt;
            vertical-align: top;
        }

        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        /* Tabel Parameter (nested dalam item) */
        .parameters-list {
            list-style: none;
            padding: 0;
            margin-top: 5px;
            margin-bottom: 0;
            font-size: 8pt;
        }

        .parameters-list li {
            padding: 1px 0;
            color: #555;
        }

        /* Ringkasan Biaya */
        .summary-wrapper {
            width: 100%;
            overflow: hidden;
            /* Clearfix */
        }

        .summary-table {
            width: 50%;
            /* Lebar tabel summary */
            float: right;
            /* Agar tabel ada di kanan */
            border-collapse: collapse;
            margin-top: 20px;
        }

        .summary-table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 9pt;
        }

        .summary-table .label {
            text-align: left;
            font-weight: normal;
            width: 60%;
            background-color: #f2f2f2;
        }

        .summary-table .value {
            text-align: right;
            font-weight: bold;
        }

        .summary-table .total-row td {
            background-color: #e6f7ff;
            font-weight: bold;
            font-size: 10pt;
            color: #0056b3;
        }

        /* Syarat & Ketentuan */
        .terms {
            margin-top: 30px;
            font-size: 9pt;
            color: #555;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .terms h4 {
            color: #333;
            margin-bottom: 10px;
        }

        /* Tanda Tangan */
        .signature-section {
            margin-top: 40px;
            overflow: hidden;
            font-size: 9pt;
        }

        .signature-section .left-col {
            float: left;
            width: 48%;
        }

        .signature-section .right-col {
            float: right;
            width: 48%;
            text-align: right;
        }

        .signature-box {
            margin-top: 50px;
            border-top: 1px solid #333;
            padding-top: 5px;
            width: 60%;
            /* Lebar garis tanda tangan */
            margin-left: 0;
            margin-right: auto;
        }


        /* Footer Dokumen */
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 8pt;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>[NAMA PERUSAHAAN ANDA]</h1>
            <p>[Alamat Perusahaan Anda, Kota, Kode Pos]</p>
            <p>Telepon: [Nomor Telepon] | Email: [Email Perusahaan] | Website: [Website Perusahaan]</p>
        </div>

        <div class="document-title">
            PENAWARAN
        </div>

        <div class="details-section">
            <div class="left-details">
                <table class="details-table">
                    <tr>
                        <td class="label-col">Nomor Penawaran</td>
                        <td>: {{ $quotation->quotation_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Nama Penawaran</td>
                        <td>: {{ $quotation->quotation_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Tanggal Penawaran</td>
                        <td>: {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d F Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Berlaku Hingga</td>
                        <td>: {{ \Carbon\Carbon::parse($quotation->valid_until_date)->format('d F Y') ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="right-details">
                <table class="details-table">
                    <tr>
                        <td class="label-col">Kepada Yth.</td>
                        <td>: **{{ $quotation->customer->customer_name ?? '-' }}**</td>
                    </tr>
                    <tr>
                        <td class="label-col">Alamat</td>
                        <td>: {{ $quotation->customer->full_address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Kontak Personil</td>
                        <td>: {{ $quotation->customer->contact_person_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Telp. Kontak</td>
                        <td>: {{ $quotation->customer->contact_phone_number ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <p class="intro-text">Dengan hormat,</p>
        <p class="intro-text">Bersama ini kami sampaikan penawaran harga untuk layanan sebagai berikut:</p>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">No.</th>
                    <th style="width: 35%;">Deskripsi Item</th>
                    <th style="width: 15%;">Regulasi</th>
                    <th class="text-center" style="width: 8%;">Kuantitas</th>
                    <th style="width: 10%;">Satuan</th>
                    <th class="text-right" style="width: 12%;">Harga Satuan</th>
                    <th class="text-right" style="width: 15%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $grandSubtotal = 0; @endphp
                @forelse($quotation->quotationItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->description ?? '-' }}</strong><br>
                            @if ($item->location)
                                <small>Lokasi: {{ $item->location }}</small><br>
                            @endif
                            @if ($item->parameterQuotationItems->isNotEmpty())
                                <ul class="parameters-list">
                                    <small><strong>Parameter:</strong></small>
                                    @foreach ($item->parameterQuotationItems as $param_snapshot)
                                        <li>- {{ $param_snapshot->parameter_name ?? '-' }}
                                            ({{ $param_snapshot->parameter_unit ?? '-' }})
                                            @if ($param_snapshot->parameter_default_test_method_name)
                                                [Metode: {{ $param_snapshot->parameter_default_test_method_name }}]
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>{{ $item->regulation_name ?? '-' }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td>{{ $item->unit ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->quantity * $item->price, 2, ',', '.') }}</td>
                    </tr>
                    @php $grandSubtotal += ($item->quantity * $item->price); @endphp
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada item penawaran yang tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td class="label">Subtotal</td>
                    <td class="value">Rp {{ number_format($grandSubtotal, 2, ',', '.') }}</td>
                </tr>
                @if ($quotation->discount_percentage > 0)
                    <tr>
                        <td class="label">Diskon ({{ number_format($quotation->discount_percentage, 2, ',', '.') }}%)
                        </td>
                        <td class="value">Rp
                            {{ number_format($grandSubtotal * ($quotation->discount_percentage / 100), 2, ',', '.') }}
                        </td>
                    </tr>
                @endif
                @if ($quotation->ppn_percentage > 0)
                    <tr>
                        <td class="label">PPN ({{ number_format($quotation->ppn_percentage, 2, ',', '.') }}%)</td>
                        <td class="value">Rp
                            {{ number_format($grandSubtotal * ($quotation->ppn_percentage / 100), 2, ',', '.') }}</td>
                    </tr>
                @endif
                @if ($quotation->pph_percentage > 0)
                    <tr>
                        <td class="label">PPH ({{ number_format($quotation->pph_percentage, 2, ',', '.') }}%)</td>
                        <td class="value">Rp
                            {{ number_format($grandSubtotal * ($quotation->pph_percentage / 100), 2, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td class="label">TOTAL AKHIR</td>
                    <td class="value">
                        Rp
                        {{ number_format(
                            $grandSubtotal -
                                $grandSubtotal * ($quotation->discount_percentage / 100) +
                                $grandSubtotal * ($quotation->ppn_percentage / 100) -
                                $grandSubtotal * ($quotation->pph_percentage / 100),
                            2,
                            ',',
                            '.',
                        ) }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="terms">
            <h4>Syarat & Ketentuan Pembayaran:</h4>
            <p>{{ $quotation->additional_description ?? 'Tidak ada syarat dan ketentuan pembayaran tambahan.' }}</p>
        </div>

        <div class="signature-section">
            <div class="left-col">
                <p>Hormat kami,</p>
                <div class="signature-box"></div>
                <p style="margin-top: 5px;">
                    <strong>{{ $quotation->personel->full_name ?? 'Nama Personil Lab' }}</strong>
                </p>
                <p>Posisi: {{ $quotation->personel->position ?? 'Posisi Personil Lab' }}</p>
            </div>
            {{-- Anda bisa menambahkan kolom kanan jika ada tanda tangan lain --}}
        </div>


        <div class="footer">
            <p>Dokumen ini dibuat secara otomatis dan berlaku tanpa tanda tangan basah.</p>
            <p>&copy; {{ date('Y') }} [Nama Perusahaan Anda]. Hak Cipta Dilindungi.</p>
        </div>
    </div>

</body>

</html>
