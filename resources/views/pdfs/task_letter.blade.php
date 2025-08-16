<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Surat Tugas - {{ $labJob->job_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            margin: 0.5in;
        }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 18pt; }
        .document-title { text-align: center; margin-bottom: 20px; font-size: 16pt; font-weight: bold; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table td { padding: 5px 0; vertical-align: top; }
        .details-table .label { width: 150px; font-weight: bold; }
        .personnel-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .personnel-table th, .personnel-table td { border: 1px solid #ddd; padding: 8px; }
        .signature-section { margin-top: 50px; }
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

    <div class="document-title">SURAT TUGAS</div>

    <table class="details-table">
        <tr>
            <td class="label">Nomor Pekerjaan</td>
            <td>: {{ $labJob->job_number ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Dikeluarkan</td>
            <td>: {{ \Carbon\Carbon::now()->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Pelanggan</td>
            <td>: {{ $labJob->quotation->customer->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Penawaran Ref.</td>
            <td>: {{ $labJob->quotation->quotation_number ?? '-' }}</td>
        </tr>
    </table>

    <p>Kepada Tim PPC yang ditugaskan, dengan ini kami memberikan surat tugas untuk melaksanakan pekerjaan:</p>
    
    <p><strong>Nama Pekerjaan:</strong> {{ $labJob->quotation->quotation_name ?? '-' }}</p>
    
    <h3>Tim yang Ditugaskan:</h3>
    <table class="personnel-table">
        <thead>
            <tr>
                <th style="width: 50%;">Nama Personel</th>
                <th style="width: 50%;">Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($labJob->labJobPersonels as $jobPersonel)
                <tr>
                    <td>{{ $jobPersonel->personel->fullname ?? '-' }}</td>
                    <td>{{ $jobPersonel->position ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center;">Tidak ada anggota tim yang ditugaskan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <p>Hormat kami,</p>
        <p>Kepala Laboratorium</p>
        <br><br><br>
        <p><strong>[NAMA KEPALA LABORATORIUM]</strong></p>
    </div>

</body>
</html>