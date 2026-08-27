<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Surat Tugas - {{ $labJob->code }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #333;
        }

        /* =============================================
           HEADER / FOOTER FIXED — konsisten dgn quotation
           & lhp.blade.php, otomatis berulang tiap halaman
           kalau konten (daftar personel) lebih dari 1 halaman
        ============================================= */
        .header-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            z-index: 1000;
            padding: 8px 40px 6px 40px;
        }

        .header-fixed img.kop-surat {
            max-width: 100%;
            display: block;
        }

        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: white;
            z-index: 1000;
            padding: 0 40px;
            border-top: 1px solid #ccc;
            display: table;
            width: 100%;
            font-size: 7pt;
        }

        .footer-left-cell {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
        }

        .footer-right-cell {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            text-align: right;
        }

        .footer-right-cell::after {
            content: "Hal " counter(page) " dari " counter(pages);
        }

        .page {
            margin: 36mm 11mm 15mm 11mm;
        }

        /* =============================================
           JUDUL DOKUMEN
        ============================================= */
        .document-title {
            text-align: center;
            margin-bottom: 4px;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
        }

        .document-number {
            text-align: center;
            margin-bottom: 20px;
            font-size: 9pt;
            color: #555;
        }

        /* =============================================
           TABEL DETAIL
        ============================================= */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 9.5pt;
        }

        .details-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .details-table .label {
            width: 150px;
            font-weight: bold;
        }

        .intro-text,
        .job-name-text {
            margin-bottom: 10px;
            text-align: justify;
        }

        .job-name-text {
            margin-top: 4px;
        }

        h3.section-heading {
            font-size: 10.5pt;
            margin: 14px 0 6px 0;
        }

        /* =============================================
           TABEL PERSONEL
        ============================================= */
        .personnel-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            font-size: 9.5pt;
        }

        .personnel-table th,
        .personnel-table td {
            border: 1px solid #333;
            padding: 6px 8px;
        }

        .personnel-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }

        .personnel-table td.no {
            width: 6%;
            text-align: center;
        }

        /* =============================================
           TANDA TANGAN
        ============================================= */
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-section p {
            margin: 1px 0;
        }

        .sig-box {
            height: 55px;
            border-bottom: 1px solid #000;
            margin: 8px 0 4px 0;
            width: 220px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }
    </style>
</head>

<body>

    {{-- ================================================
         HEADER & FOOTER FIXED — berulang otomatis tiap
         halaman, tidak hilang kalau daftar personel panjang
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
            <img src="{{ $korpBase64 }}" alt="Kop Surat Perusahaan" class="kop-surat">
        @endif
    </div>

    <div class="footer-fixed">
        <div class="footer-left-cell">No. Dok.: FSOP.JLI-11.1</div>
        <div class="footer-right-cell"></div>
    </div>

    <div class="page">
        <div class="document-title">SURAT TUGAS</div>
        <div class="document-number">Nomor: {{ $labJob->code ?? '-' }}</div>

        <table class="details-table">
            <tr>
                <td class="label">Nomor Lab Job</td>
                <td>: {{ $labJob->code ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Dikeluarkan</td>
                <td>: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="label">Pelanggan</td>
                <td>: {{ $labJob->quotation->customer->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Penawaran Ref.</td>
                <td>: {{ $labJob->quotation->code ?? '-' }}</td>
            </tr>
        </table>

        <p class="intro-text">
            Kepada Tim PPC yang ditugaskan, dengan ini kami memberikan surat tugas untuk melaksanakan pekerjaan:
        </p>

        <p class="job-name-text"><strong>Nama Pekerjaan:</strong> {{ $labJob->quotation->name ?? '-' }}</p>

        <h3 class="section-heading">Tim yang Ditugaskan:</h3>
        <table class="personnel-table">
            <thead>
                <tr>
                    <th class="no">No</th>
                    <th style="width: 47%;">Nama Personel</th>
                    <th style="width: 47%;">Jabatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($labJob->labJobPersonels as $i => $jobPersonel)
                    <tr>
                        <td class="no">{{ $i + 1 }}</td>
                        <td>{{ $jobPersonel->personel->fullname ?? '-' }}</td>
                        {{-- TODO: konfirmasi field ini — jika `position` adalah relasi
                             (bukan string langsung), ganti ke:
                             {{ $jobPersonel->personel->position->name ?? '-' }}
                             atau field pivot yg sesuai --}}
                        <td>{{ $jobPersonel->position ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">Tidak ada anggota tim yang ditugaskan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="signature-section">
            <p>{{ $company->city->name ?? 'Jambi' }}, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
            <p style="margin-top:6px;">Hormat kami,</p>
            <p>Kepala Laboratorium</p>
            <div class="sig-box"></div>
            {{-- TODO: sesuaikan relasi personil kepala lab yg menandatangani,
                 sama seperti di lhp.blade.php --}}
            <p class="sig-name">{{ $company->head_of_lab_name ?? '[________________________________]' }}</p>
        </div>
    </div>

</body>

</html>
