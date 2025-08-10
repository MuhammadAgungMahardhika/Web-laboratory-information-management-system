<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Penawaran - {{ $quotation->quotation_number }}</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #333;
            padding-top: 90px;
            /* Adjust this value if header collision persists */
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 0 20px 15px 20px;
            box-sizing: border-box;
        }

        .header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 120px;
            /* Adjust this to fit your korp.jpg's actual height if different */
            padding: 10px 20px;
            /* Padding inside the absolute header (for image) */
            /* border-bottom: 1px solid #eee; */
            text-align: center;
            box-sizing: border-box;
            z-index: 1000;
        }

        .header img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .document-title {
            text-align: center;
            color: #000000;
            font-size: 12pt;
            margin-bottom: 20px;
            margin-top: 0;
            /* Ensure no margin collapse */
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 8.5pt;
        }

        .details-table .label-col {
            width: 22%;
            font-weight: bold;
            color: #555;
        }

        .intro-text {
            margin-bottom: 15px;
            font-size: 9pt;
        }

        .items-table {
            table-layout: fixed;
            /* ⬅️ PENTING: Membuat lebar kolom tetap */
            width: 95%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 7pt;
            vertical-align: top;
            /* --- PENTING: Pengaturan untuk pembungkus teks --- */
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            /* ------------------------------------------------- */
        }

        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .parameters-list {
            list-style: none;
            margin: 0;
            padding: 0;
            font-size: 8pt;
            /* Sedikit lebih besar dari 7.5pt */
        }

        /* Ganti dengan kode ini (Flexbox) */



        .summary-table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 7pt;
        }

        .summary-table .label {
            background-color: #f2f2f2;
        }

        .summary-table .value {
            text-align: right;
            font-weight: bold;
        }

        .summary-table .total-row td {
            background-color: #e6f7ff;
            color: #0056b3;
            font-weight: bold;
        }

        .terms {
            margin-top: 25px;
            font-size: 8.5pt;
            color: #555;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .signature-section {
            margin-top: 30px;
            overflow: hidden;
            font-size: 8.5pt;
        }

        .left-col {
            float: left;
            width: 48%;
        }

        .signature-box {
            margin-top: 40px;
            border-top: 1px solid #333;
            padding-top: 5px;
            width: 60%;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 7.5pt;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }

        @page {
            margin: 0.5in;
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
            <img src="{{ $korpBase64 }}" alt="Kop Surat Perusahaan">
        @endif
    </div>

    <div class="container">
        <div class="document-title">PENAWARAN HARGA</div>

        <table class="details-table">
            <tr>
                <td class="label-col">Nomor Penawaran</td>
                <td>: {{ $quotation->quotation_number ?? '-' }}</td>
                <td class="label-col">Kepada Yth.</td>
                <td>: <strong>{{ $quotation->customer->name ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">Nama Penawaran</td>
                <td>: {{ $quotation->quotation_name ?? '-' }}</td>
                <td class="label-col">Alamat</td>
                <td>: {{ $quotation->customer->full_address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tanggal Penawaran</td>
                <td>: {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d F Y') ?? '-' }}</td>
                <td class="label-col">Kontak Personil</td>
                <td>: {{ $quotation->customer->contact_person_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Berlaku Hingga</td>
                <td>: {{ \Carbon\Carbon::parse($quotation->valid_until_date)->format('d F Y') ?? '-' }}</td>
                <td class="label-col">Telp. Kontak</td>
                <td>: {{ $quotation->customer->contact_phone_number ?? '-' }}</td>
            </tr>
        </table>

        <p class="intro-text">Dengan hormat,</p>
        <p class="intro-text">Bersama ini kami sampaikan penawaran harga untuk layanan sebagai berikut:</p>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">No.</th>
                    <th style="width: 20%;">Deskripsi Item & Lokasi</th>
                    <th style="width: 14%;">Regulasi</th>
                    <th style="width: 19%;">Parameter</th>
                    <th style="width: 7%; text-align: right;">Jumlah</th>
                    <th style="width: 9%;">Satuan</th>
                    <th style="width: 12%; text-align: right;">Harga (Rp)</th>
                    <th style="width: 14%; text-align: right;">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php $grandSubtotal = 0; @endphp
                @foreach ($quotation->quotationItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->description ?? '-' }}</strong><br>
                            @if ($item->location)
                                <small>Lokasi: {{ $item->location }}</small>
                            @endif
                        </td>
                        <td>{{ $item->regulation_name ?? '-' }}</td>
                        <td>
                            @if ($item->parameterQuotationItems->isNotEmpty())
                                {{-- Mengambil semua 'parameter_name' dan menggabungkannya dengan koma dan spasi --}}
                                {{ $item->parameterQuotationItems->pluck('parameter_name')->implode(', ') }}
                            @else
                                - {{-- Tampilkan tanda hubung jika tidak ada parameter --}}
                            @endif
                        </td>
                        <td class="text-center" style="text-align: right;">{{ $item->quantity ?? 0 }}</td>
                        <td>{{ $item->unit ?? '-' }}</td>
                        <td class="text-right" style="text-align: right;">
                            {{ number_format($item->price, 2, ',', '.') }}</td>
                        <td class="text-right" style="text-align: right;">
                            {{ number_format(($item->quantity ?? 0) * $item->price, 2, ',', '.') }}</td>
                    </tr>
                    @php $grandSubtotal += (($item->quantity ?? 0) * $item->price); @endphp
                @endforeach
            </tbody>
            <tfoot class="summary-table">
                <tr>
                    <td class="label" colspan="7">Subtotal</td>
                    <td class="value">Rp {{ number_format($grandSubtotal, 2, ',', '.') }}</td>
                </tr>
                @if ($quotation->discount_percentage > 0)
                    <tr>
                        <td class="label" colspan="7">Diskon
                            ({{ number_format($quotation->discount_percentage, 2, ',', '.') }}%)
                        </td>
                        <td class="value">Rp
                            {{ number_format($grandSubtotal * ($quotation->discount_percentage / 100), 2, ',', '.') }}
                        </td>
                    </tr>
                @endif
                @if ($quotation->ppn_percentage > 0)
                    <tr>
                        <td class="label" colspan="7">PPN
                            ({{ number_format($quotation->ppn_percentage, 2, ',', '.') }}%)</td>
                        <td class="value">Rp
                            {{ number_format($grandSubtotal * ($quotation->ppn_percentage / 100), 2, ',', '.') }}</td>
                    </tr>
                @endif
                @if ($quotation->pph_percentage > 0)
                    <tr>
                        <td class="label" colspan="7">PPH
                            ({{ number_format($quotation->pph_percentage, 2, ',', '.') }}%)</td>
                        <td class="value">Rp
                            {{ number_format($grandSubtotal * ($quotation->pph_percentage / 100), 2, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td class="label" colspan="7">TOTAL AKHIR</td>
                    <td class="value" style="">
                        Rp
                        {{ number_format(
                            $grandSubtotal -
                                ($grandSubtotal * ($quotation->discount_percentage ?? 0)) / 100 +
                                ($grandSubtotal * ($quotation->ppn_percentage ?? 0)) / 100 -
                                ($grandSubtotal * ($quotation->pph_percentage ?? 0)) / 100,
                            2,
                            ',',
                            '.',
                        ) }}
                    </td>
                </tr>
            </tfoot>
        </table>


        <div class="terms">
            <h4>
                Syarat & Ketentuan Pembayaran:
            </h4>
            {!! $quotation->additional_description ?? 'Tidak ada syarat dan ketentuan pembayaran tambahan.' !!}
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
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis dan berlaku tanpa tanda tangan basah.</p>
        <p>&copy; {{ date('Y') }} [{{ $company->name }}]. Hak Cipta Dilindungi.</p>
    </div>
</body>

</html>
