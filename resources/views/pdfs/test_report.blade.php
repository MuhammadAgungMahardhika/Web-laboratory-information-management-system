<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Laporan Hasil Uji - {{ $labJob->job_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0.5in;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16pt;
            margin: 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .details-table .label {
            font-weight: bold;
            width: 150px;
        }

        .section-heading {
            font-size: 12pt;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .results-table th,
        .results-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        .results-table thead th {
            background-color: #f2f2f2;
        }

        .signature-section {
            margin-top: 40px;
            text-align: center;
        }

        .signature-box {
            margin-top: 60px;
            border-top: 1px solid #333;
            width: 250px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>LAPORAN HASIL UJI</h1>
        <p>Nomor Laporan: {{ $labJob->job_number ?? '-' }}</p>
    </div>

    <div class="section-heading">Informasi Umum</div>
    <table class="details-table">
        <tr>
            <td class="label">Pelanggan</td>
            <td>: <strong>{{ $labJob->quotation->customer->name ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td>: {{ $labJob->quotation->customer->full_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Laporan</td>
            <td>: {{ \Carbon\Carbon::now()->format('d F Y') }}</td>
        </tr>
    </table>

    <div class="section-heading">Rincian Pengujian</div>
    @foreach ($labJob->labJobItems as $item)
        <h4>Item Lab Job: {{ $item->description ?? '-' }}</h4>
        <p>Total Sampel: {{ $item->samples->count() }}</p>

        @foreach ($item->samples as $sample)
            <p style="font-weight: bold; margin-bottom: 5px;">Kode Sampel: {{ $sample->sample_code ?? '-' }}</p>
            <table class="results-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Parameter Uji</th>
                        <th style="width: 15%;">Hasil Uji</th>
                        <th style="width: 10%;">Satuan</th>
                        <th style="width: 25%;">Baku Mutu Referensi</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 10%;">Analis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sample->testResults as $result)
                        <tr>
                            <td>{{ $result->parameter->name ?? '-' }}</td>
                            <td>{{ $result->tested_value ?? '-' }}</td>
                            <td>{{ $result->unit ?? '-' }}</td>
                            <td>{{ $result->standard_value_ref_min ?? '-' }} -
                                {{ $result->standard_value_ref_max ?? '-' }}</td>
                            <td>{{ $result->status ?? '-' }}</td>
                            <td>{{ $result->analystPersonnel->full_name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach

    <div class="signature-section">
        <p>Laporan ini dibuat secara otomatis dan berlaku tanpa tanda tangan basah.</p>
        <p>Disetujui oleh:</p>
        <div class="signature-box"></div>
        <p><strong>[NAMA PENYETUJU]</strong></p>
        <p>Jabatan: [JABATAN]</p>
    </div>

</body>

</html>
