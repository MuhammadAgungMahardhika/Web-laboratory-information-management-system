<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Laporan Pengujian - {{ $labJob->job_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            margin: 0;
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

        .page-break {
            page-break-before: always;
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
        <p>Tanggal Dikeluarkan: {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    </div>

    <div class="section-heading">Informasi Umum</div>
    <table class="details-table">
        <tr>
            <td class="label">Nama Pelanggan</td>
            <td>: <strong>{{ $labJob->quotation->customer->name ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Alamat Lengkap</td>
            <td>: {{ $labJob->quotation->customer->full_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Pekerjaan</td>
            <td>: {{ $labJob->job_number ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Registrasi</td>
            [cite_start]<td>: 00119/LPJ/LABLING-1/LRK/KLHK [cite: 7]</td>
        </tr>
    </table>

    <div class="section-heading">Rincian Sampel</div>
    <table class="results-table">
        <thead>
            <tr>
                <th>Identifikasi Sampel</th>
                <th>Matriks</th>
                <th>Tanggal Pengambilan</th>
                <th>Tanggal Penerimaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labJob->labJobItems as $item)
                @foreach ($item->samples as $sample)
                    <tr>
                        <td>{{ $sample->sample_code ?? '-' }}</td>
                        <td>{{ $item->testPackage->sampleMatrix->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($sample->collection_date)->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($sample->reception_date)->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="section-heading">Keterangan Tambahan</div>
    <p>... (Catatan atau disclaimer dari `reports.notes` atau `companies`)...</p>
    [cite_start]<p>Laporan ini dibuat berdasarkan hasil observasi yang objektif dan independen... [cite: 14]</p>


    @foreach ($labJob->labJobItems as $item)
        @foreach ($item->samples as $sample)
            <div class="page-break"></div>
            <div class="header">
                <h1>LAPORAN HASIL UJI</h1>
                <p>Nomor Laporan: {{ $labJob->job_number ?? '-' }}</p>
            </div>
            <div class="section-heading">Pengujian untuk Sampel: {{ $sample->sample_code }}</div>
            <table class="details-table">
                <tr>
                    <td class="label">Identifikasi Sampel</td>
                    <td>: {{ $sample->sample_code ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Matriks</td>
                    <td>: {{ $item->testPackage->sampleMatrix->name ?? '-' }}</td>
                </tr>
            </table>

            <table class="results-table">
                <thead>
                    <tr>
                        <th style="width: 20%;">Parameter Uji</th>
                        <th style="width: 15%;">Pengujian</th>
                        <th style="width: 10%;">Satuan</th>
                        <th style="width: 20%;">Baku Mutu Referensi</th>
                        <th style="width: 15%;">Metode</th>
                        <th style="width: 20%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sample->testResults as $result)
                        <tr>
                            <td>{{ $result->parameter->code ?? '-' }}</td>
                            <td>{{ $result->tested_value ?? '-' }}</td>
                            <td>{{ $result->unit ?? '-' }}</td>
                            <td>{{ $result->standard_value_ref_min ?? '-' }} -
                                {{ $result->standard_value_ref_max ?? '-' }}</td>
                            <td>{{ $result->testMethod->name ?? '-' }}</td>
                            <td>{{ $result->status->label() ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach

    <div class="page-break"></div>
    <div class="signature-section">
        <p>Laporan ini dibuat secara otomatis.</p>
        <p>Disetujui oleh:</p>
        <br><br><br>
        <p><strong>{{ $labJob->approvedByPersonel->full_name ?? '[Nama Penyetuju]' }}</strong></p>
        <p>Jabatan: {{ $labJob->approvedByPersonel->position->name ?? '[Jabatan]' }}</p>
    </div>

</body>

</html>
