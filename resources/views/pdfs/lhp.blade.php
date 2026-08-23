<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>LHP - {{ $labJob->code }}</title>
    <style>
        /* =============================================
           RESET & BASE (disamakan dgn quotation.blade.php)
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
           HEADER / FOOTER FIXED (kop surat sama spt quotation)
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
            margin-bottom: 5px;
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
            content: counter(page) " dari " counter(pages);
        }

        .page {
            margin: 36mm 11mm 15mm 11mm;
        }

        .page-break {
            page-break-after: always;
        }

        /* =============================================
           HALAMAN 1 — COVER LHP (dgn background dekoratif)
        ============================================= */
        .page-cover {
            position: relative;
        }

        .cover-page-wrapper {
            position: relative;
        }

        .cover-bg-image {
            position: absolute;
            top: -36mm;
            left: -11mm;
            width: 210mm;
            height: 297mm;
            object-fit: cover;
            opacity: 0.16;
            background-color: #1a5f9e;
        }


        .cover-content {
            position: relative;
        }

        .lhp-title {
            text-align: center;
            margin-bottom: 18px;
        }

        .lhp-title h1 {
            font-size: 14pt;
            text-decoration: underline;
        }

        .lhp-title h2 {
            font-size: 10pt;
            font-style: italic;
            font-weight: normal;
            margin-top: 2px;
        }

        .lhp-title h3 {
            font-size: 12pt;
            color: #1a5f9e;
            margin-top: 4px;
        }

        .cover-info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 20px;
        }

        .cover-info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .cover-info-table td.label {
            width: 22%;
            white-space: nowrap;
        }

        .cover-info-table td.colon {
            width: 2%;
        }

        .cover-info-table td.value {
            font-weight: bold;
        }

        .cover-signature {
            margin-top: 60px;
            width: 45%;
        }

        .cover-signature .sig-space {
            height: 60px;
        }

        .cover-disclaimer {
            border: 1px solid #333;
            padding: 8px 10px;
            margin-top: 50px;
            font-size: 7pt;
            text-align: justify;
            line-height: 1.5;
        }

        /* =============================================
           HALAMAN 2 — INFORMASI CONTOH UJI
        ============================================= */
        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 8.5pt;
            font-style: italic;
            margin-bottom: 10px;
        }

        .job-meta-table {
            width: 100%;
            font-size: 8pt;
            margin-bottom: 8px;
        }

        .job-meta-table td {
            padding: 1px 0;
        }

        .job-meta-table td.label {
            width: 22%;
        }

        .sample-info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
            table-layout: fixed;
        }

        .sample-info-table th,
        .sample-info-table td {
            border: 1px solid #333;
            padding: 3px 4px;
            vertical-align: top;
            word-break: break-word;
        }

        .sample-info-table th {
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
        }

        /* =============================================
           HALAMAN HASIL UJI (per kategori/matriks)
        ============================================= */
        .lhp-header-block {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
            margin-bottom: 8px;
        }

        .lhp-header-block td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .lhp-header-block .label {
            width: 20%;
        }

        .matrix-title {
            font-weight: bold;
            font-size: 9pt;
            margin: 8px 0 4px 0;
            background-color: #dedede;
            padding: 3px 5px;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
            table-layout: fixed;
            margin-bottom: 4px;
        }

        .results-table th,
        .results-table td {
            border: 1px solid #333;
            padding: 3px 4px;
            vertical-align: middle;
            word-break: break-word;
        }

        .results-table th {
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .results-table td.no {
            width: 3%;
            text-align: center;
        }

        .results-table td.param-name {
            width: 27%;
        }

        .results-table td.result {
            text-align: center;
        }

        .results-table td.bml {
            width: 10%;
            text-align: center;
        }

        .results-table td.unit {
            width: 8%;
            text-align: center;
        }

        .results-table td.method {
            width: 17%;
        }

        .env-condition-title {
            font-weight: bold;
            font-size: 7.5pt;
            margin: 6px 0 3px 0;
        }

        .notes-block {
            font-size: 6.5pt;
            margin-top: 6px;
            line-height: 1.4;
        }

        .notes-block p {
            margin-bottom: 2px;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }
    </style>
</head>

<body>

    {{-- ================================================
         HEADER & FOOTER FIXED — reuse kop surat perusahaan
         (logo perusahaan + KAN + Nomor Registrasi diasumsikan
         sudah menyatu dalam 1 gambar letterhead, sama seperti
         di quotation.blade.php)
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
    </div>

    <div class="footer-fixed">
        <div class="footer-left-cell">No. Dok.: FSOP.JLI-11.1</div>
        <div class="footer-right-cell"></div>
    </div>

    {{-- ================================================
         HALAMAN 1 — COVER LHP
    ================================================ --}}
    <div class="page page-break">
        <div class="cover-page-wrapper">
            {{-- Background dekoratif cover, dari file gambar (bukan CSS/SVG manual).
                 Simpan file di public/images/cover-bg.jpg, atau sesuaikan path/
                 sumbernya (mis. dari setting company) di bawah ini. --}}
            @php
                // TODO: sesuaikan sumber file background cover, mis. dari setting company:
                // $coverBgPath = $company->active_setting?->cover_background_path
                //     ? public_path('storage/' . $company->active_setting->cover_background_path)
                //     : public_path('images/cover-bg.jpg');
                $coverBgPath = public_path('images/cover-bg.jpg');
                $coverBgBase64 = '';
                if (file_exists($coverBgPath)) {
                    $coverBgData = file_get_contents($coverBgPath);
                    $coverBgType = pathinfo($coverBgPath, PATHINFO_EXTENSION);
                    $coverBgBase64 = 'data:image/' . $coverBgType . ';base64,' . base64_encode($coverBgData);
                }
            @endphp
            @if ($coverBgBase64)
                <img src="{{ $coverBgBase64 }}" class="cover-bg-image" alt="">
            @endif

            <div class="cover-content">
                <div class="lhp-title">
                    <h1>LAPORAN HASIL PENGUJIAN</h1>
                    <h2>CERTIFICATE OF ANALYSIS</h2>
                    <h3>{{ $labJob->code }}</h3>
                </div>

                @php
                    // Hanya lab_job_items group A yang relevan utk LHP
                    $reportItems = $labJob->labJobItems->where('group', 'A');
                    $totalSamples = $reportItems->flatMap->samples->count();
                    $customer = $labJob->quotation->customer;
                @endphp

                <table class="cover-info-table">
                    <tr>
                        <td class="label">Nama Pelanggan/<br><i>Customer</i></td>
                        <td class="colon">:</td>
                        <td class="value">{{ strtoupper($customer->name ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Personil Penghubung/<br><i>Contact Person</i></td>
                        <td class="colon">:</td>
                        <td class="value">{{ $customer->contact_person_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Alamat Lengkap/<br><i>Address</i></td>
                        <td class="colon">:</td>
                        <td class="value">{{ $customer->full_address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama Kegiatan/<br><i>Project Name</i></td>
                        <td class="colon">:</td>
                        {{-- TODO: sesuaikan sumber nama kegiatan, mis. $labJob->quotation->name --}}
                        <td class="value">{{ $labJob->quotation->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jumlah Contoh Uji/<br><i>Samples</i></td>
                        <td class="colon">:</td>
                        <td class="value">{{ $totalSamples }}</td>
                    </tr>
                </table>

                <div class="cover-signature">
                    <p>{{ $company->city ?? 'Jambi' }}, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                    <div class="sig-space"></div>
                    {{-- TODO: sesuaikan relasi personil kepala lab yang menandatangani --}}
                    <p><strong><u>{{ $labJob->labJobPersonels->first()?->personel?->fullname ?? 'Kepala Laboratorium' }}</u></strong>
                    </p>
                    <p>Kepala Laboratorium</p>
                </div>

                <div class="cover-disclaimer">
                    Laporan ini dibuat berdasarkan hasil observasi yang objektif dan independen terhadap sampel
                    pelanggan
                    yang bersifat khusus dan rahasia. Data hasil pengujian, interpretasi, dan pendapat-pendapat yang ada
                    di
                    dalamnya mewakili penilaian terbaik dari {{ $company->name ?? '-' }}. Dalam hal penggunaan laporan
                    ini,
                    {{ $company->name ?? '-' }} tidak membuat jaminan secara tersirat maupun tersurat dan tidak
                    bertanggung jawab terhadap produktivitas, kegiatan operasional, ataupun kerugian lainnya yang
                    bersifat
                    material maupun imaterial. Laporan ini tidak diperbolehkan untuk digandakan, kecuali secara utuh
                    keseluruhannya dan atas persetujuan tertulis dari {{ $company->name ?? '-' }}.
                </div>
            </div><!-- /.cover-content -->
        </div><!-- /.cover-page-wrapper -->
    </div>

    {{-- ================================================
         HALAMAN 2 — INFORMASI CONTOH UJI
    ================================================ --}}
    <div class="page page-break">
        <div class="cover-page-wrapper">
            @if ($coverBgBase64)
                <img src="{{ $coverBgBase64 }}" class="cover-bg-image" alt="">
            @endif
            <div class="section-title">INFORMASI CONTOH UJI</div>
            <div class="section-subtitle">SAMPLE INFORMATION</div>

            <table class="job-meta-table">
                <tr>
                    <td class="label">Nomor Pekerjaan/<i>Job Number</i></td>
                    <td>: {{ $labJob->code }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Pelanggan/<i>Customer</i></td>
                    <td>: {{ $customer->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Personil Penghubung/<i>Contact Person</i></td>
                    <td>: {{ $customer->contact_person_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Dilaporkan/<i>Reported Date</i></td>
                    <td>: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</td>
                </tr>
            </table>

            <table class="sample-info-table">
                <thead>
                    <tr>
                        <th>Identifikasi Lab/<br><i>Lab ID</i></th>
                        <th>Identifikasi Sampel/<br><i>Sample ID</i></th>
                        <th>Matriks/<br><i>Matrix</i></th>
                        <th>Tgl. Pengambilan/<br><i>Sampling Date</i></th>
                        <th>Waktu/<br><i>Time</i></th>
                        <th>Tgl. Diterima/<br><i>Received Date</i></th>
                        <th>Koordinat/<br><i>Coordinate</i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportItems as $item)
                        @foreach ($item->samples as $sample)
                            <tr>
                                <td>{{ $labJob->code }}-{{ $loop->parent->index + 1 }}/{{ $reportItems->count() }}
                                </td>
                                <td>{{ $sample->code }} ({{ $item->location ?? $item->description }})</td>
                                {{-- Matriks diambil dari description lab_job_item --}}
                                <td>{{ $item->description }}</td>
                                <td>{{ $sample->collection_date ? \Carbon\Carbon::parse($sample->collection_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $sample->collection_time ? \Carbon\Carbon::parse($sample->collection_time)->format('H:i') : '-' }}
                                </td>
                                <td>{{ $sample->received_date ? \Carbon\Carbon::parse($sample->received_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    @if ($sample->latitude && $sample->longitude)
                                        LS: {{ $sample->latitude }} / BT: {{ $sample->longitude }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================================================
         HALAMAN HASIL PENGUJIAN — dikelompokkan per kategori
         parameter (matriks): Udara Ambien, Kebauan, Kebisingan,
         ESTB, dsb. Dalam 1 tabel bisa memuat >1 sample sbg kolom
         (mengikuti gaya 2 sample/tabel di contoh asli), namun di
         sini dibuat dinamis mengikuti jumlah sample per kategori.

         ASUMSI: setiap parameter punya relasi kategori/matriks,
         mis. $parameter->category->name. Sesuaikan bila nama
         relasi berbeda.
    ================================================ --}}
    @php
        // Kumpulkan semua test result dari item group A, dikelompokkan
        // per kategori parameter, lalu per sample sbg kolom hasil.
        $allTestResults = $reportItems->flatMap->samples->flatMap(function ($sample) {
            return $sample->testResults->map(function ($tr) use ($sample) {
                $tr->sampleRef = $sample;
                return $tr;
            });
        });

        $groupedByCategory = $allTestResults->groupBy(function ($tr) {
            // TODO: sesuaikan relasi kategori/matriks parameter
            return $tr->parameter?->category?->name ?? 'Umum';
        });

        // Kumpulkan sample unik per kategori utk jadi kolom tabel

    @endphp

    @foreach ($groupedByCategory as $categoryName => $resultsInCategory)
        @php
            $samplesInCategory = $resultsInCategory->pluck('sampleRef')->unique('id')->values();
            $sampleChunks = $samplesInCategory->chunk(2); // 2 sample per tabel, spt contoh asli
            $paramList = $resultsInCategory->pluck('parameter')->unique('id')->values();
        @endphp

        @foreach ($sampleChunks as $chunkIndex => $samplesChunk)
            <div class="page @if (!$loop->last || !$loop->parent->last) page-break @endif">
                <div class="cover-page-wrapper">
                    @if ($coverBgBase64)
                        <img src="{{ $coverBgBase64 }}" class="cover-bg-image" alt="">
                    @endif
                    <div class="section-title">LAPORAN HASIL PENGUJIAN</div>
                    <div class="section-subtitle">CERTIFICATE OF ANALYSIS — {{ $labJob->code }}</div>

                    <table class="lhp-header-block">
                        <tr>
                            <td class="label">Identifikasi Contoh Uji/<br><i>Sample Identification</i></td>
                            <td>
                                @foreach ($samplesChunk as $s)
                                    {{ $s->code }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    </table>

                    <div class="matrix-title">{{ strtoupper($categoryName) }}</div>

                    <table class="results-table">
                        <thead>
                            <tr>
                                <th rowspan="2" class="no">No</th>
                                <th rowspan="2">Parameter</th>
                                <th colspan="{{ $samplesChunk->count() }}">Hasil/<i>Result</i></th>
                                <th rowspan="2">BML/<br>EQS*</th>
                                <th rowspan="2">Satuan/<br><i>Unit</i></th>
                                <th rowspan="2">Metode/<br><i>Method</i></th>
                            </tr>
                            <tr>
                                @foreach ($samplesChunk as $s)
                                    <th>{{ $s->code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paramList as $i => $param)
                                <tr>
                                    <td class="no">{{ $i + 1 }}</td>
                                    <td class="param-name">{{ $param->name ?? $param->parameter_code }}</td>
                                    @foreach ($samplesChunk as $s)
                                        @php
                                            $tr = $resultsInCategory->first(
                                                fn($r) => $r->sampleRef->id === $s->id &&
                                                    $r->parameter_id === $param->id,
                                            );
                                        @endphp
                                        <td class="result">{{ $tr->tested_value ?? '-' }}</td>
                                    @endforeach
                                    {{-- TODO: sesuaikan sumber nilai BML/EQS aktual --}}
                                    <td class="bml">{{ $param->standard_notes ?? '-' }}</td>
                                    <td class="unit">{{ $param->unit ?? '-' }}</td>
                                    <td class="method">{{ $param->testMethod?->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endforeach

    {{-- ================================================
         CATATAN KAKI umum (opsional, sesuaikan per matriks
         seperti pada contoh asli — bisa dipecah per section)
    ================================================ --}}
    <div class="page">
        <div class="cover-page-wrapper">
            @if ($coverBgBase64)
                <img src="{{ $coverBgBase64 }}" class="cover-bg-image" alt="">
            @endif
            <div class="notes-block">
                <p><strong>Keterangan/Note:</strong></p>
                <p>(*) BML adalah Baku Mutu Lingkungan Sesuai Peraturan Pemerintah RI No. 22 Tahun 2021 Tentang
                    Penyelenggaraan Perlindungan dan Pengelolaan Lingkungan Hidup.</p>
                <p>&lt; Menunjukkan nilai terkecil dari pengukuran yang didapatkan berdasarkan metode yang berlaku.</p>
                <p>Hasil hanya berhubungan dengan contoh yang diuji dan laporan ini tidak boleh digandakan kecuali
                    seluruhnya. <i>The result relate only to the samples tested and this report shall not be reproduced
                        except in full.</i></p>
            </div>
        </div>
    </div>

</body>

</html>
