<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>LPA - {{ $labJob->code }}</title>
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
            font-size: 8pt;
            line-height: 1.35;
            color: #333;
        }

        /* =============================================
           HEADER / FOOTER FIXED — konsisten dgn quotation,
           lhp.blade.php & task_letter.blade.php
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
           JUDUL DOKUMEN — mengikuti gaya section-title lhp
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

        /* =============================================
           INFO HEADER (Job Number, Tanggal, dst)
        ============================================= */
        .info-table {
            width: 100%;
            font-size: 8pt;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 2px 5px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            white-space: nowrap;
        }

        /* =============================================
           TABEL UTAMA HASIL PENGUJIAN
        ============================================= */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
            margin-bottom: 10px;
            table-layout: fixed;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #333;
            padding: 3px 4px;
            text-align: left;
            vertical-align: middle;
            word-break: break-word;
        }

        .main-table td.result-cell {
            text-align: center;
            vertical-align: middle;
        }

        .main-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 7pt;
            text-align: center;
        }

        .group-header {
            background-color: #dedede;
            font-weight: bold;
            text-align: left;
            font-size: 8pt;
        }

        .subgroup-header {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 7pt;
        }

        .parameter-cell {
            text-align: left;
            padding-left: 6px;
        }

        .number-cell {
            text-align: center;
            width: 4%;
        }

        .unit-cell {
            text-align: center;
            width: 8%;
        }

        .result-cell {
            text-align: center;
            vertical-align: middle;
        }

        .signature-cell {
            width: 7%;
            text-align: center;
        }

        /* =============================================
           TANDA TANGAN FOOTER
        ============================================= */
        .footer-table {
            width: 100%;
            margin-top: 16px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .footer-table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
            font-size: 8pt;
            height: 60px;
            vertical-align: bottom;
        }

        .signature-name {
            margin-bottom: 46px;
            font-weight: bold;
        }

        .date-line {
            border-bottom: 1px solid #000;
            width: 100px;
            display: inline-block;
            margin-left: 5px;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }
    </style>
</head>

<body>

    {{-- ================================================
         HEADER & FOOTER FIXED — sama persis dgn lhp.blade.php
         & task_letter.blade.php, otomatis berulang tiap halaman
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

    <div class="page">
        <div class="section-title">LEMBAR PENGUJIAN ANALIS</div>
        <div class="section-subtitle">ANALYST TEST REPORT — {{ $labJob->code }}</div>

        {{-- Header Info --}}
        <table class="info-table">
            <tr>
                <td class="info-label">Job Number</td>
                <td>: {{ $labJob->code }}</td>
                <td class="info-label">Tanggal Uji</td>
                <td>:
                    {{ $labJob->start_date ? \Carbon\Carbon::parse($labJob->start_date)->format('d/m/Y') : '___________' }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Bahan Produk</td>
                <td>:
                    @foreach ($labJob->labJobItems as $item)
                        {{ $item->description }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                </td>
                <td class="info-label">Tanggal TAT</td>
                <td>:
                    {{ $labJob->end_date ? \Carbon\Carbon::parse($labJob->end_date)->format('d/m/Y') : '___________' }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Jumlah Contoh Uji</td>
                <td>:
                    @foreach ($labJob->labJobItems as $item)
                        {{ $item->samples->count() }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                </td>
                <td class="info-label">Keterangan Lain</td>
                <td>:
                    @php
                        use App\Models\Enums\SampleCollectionTypeEnum;
                        $collectionTypes = [];
                        foreach ($labJob->labJobItems as $item) {
                            foreach ($item->samples as $sample) {
                                if ($sample->collection_type) {
                                    $typeLabel = SampleCollectionTypeEnum::labels()[$sample->collection_type];
                                    $collectionTypes[$typeLabel] = ($collectionTypes[$typeLabel] ?? 0) + 1;
                                }
                            }
                        }
                        $formattedTypes = [];
                        foreach ($collectionTypes as $type => $count) {
                            $formattedTypes[] = $type . ' (' . $count . ')';
                        }
                    @endphp
                    {{ implode(', ', $formattedTypes) }}
                </td>
            </tr>
        </table>

        {{-- Main Table --}}
        <table class="main-table">
            <thead>
                <tr>
                    <th rowspan="2" class="number-cell">No</th>
                    <th rowspan="2" style="width: 24%;">Parameter</th>
                    <th rowspan="2" class="unit-cell">Satuan</th>
                    @php
                        // TODO: sesuaikan ke $item->samples->count() (bukan method call)
                        // agar tidak query berulang, jika relasi sudah eager loaded
                        $maxSamplesInMatrix = 0;
                        foreach ($labJob->labJobItems as $item) {
                            $sampleCount = $item->samples->count();
                            if ($sampleCount > $maxSamplesInMatrix) {
                                $maxSamplesInMatrix = $sampleCount;
                            }
                        }
                    @endphp
                    <th colspan="{{ $maxSamplesInMatrix }}">Pengujian</th>
                    <th rowspan="2" class="signature-cell">Paraf</th>
                </tr>
                <tr>
                    <th class="result-cell" colspan="{{ $maxSamplesInMatrix }}"></th>
                </tr>
            </thead>
            <tbody>
                @php $rowNumber = 1; @endphp

                @foreach ($labJob->labJobItems as $jobItem)
                    {{-- Header Matriks --}}
                    <tr>
                        <td colspan="{{ 3 + $maxSamplesInMatrix + 1 }}" class="group-header">
                            {{ strtoupper($jobItem->description) }}
                        </td>
                    </tr>

                    {{-- Sub-header nomor sample per matriks --}}
                    <tr>
                        <th class="number-cell"></th>
                        <th></th>
                        <th class="unit-cell"></th>
                        @php $currentMatrixSampleCount = $jobItem->samples->count(); @endphp
                        @for ($i = 1; $i <= $currentMatrixSampleCount; $i++)
                            <th class="result-cell subgroup-header">{{ $i }} /
                                {{ $currentMatrixSampleCount }}</th>
                        @endfor
                        @for ($i = $currentMatrixSampleCount + 1; $i <= $maxSamplesInMatrix; $i++)
                            <th class="result-cell" style="background-color: #f5f5f5;">-</th>
                        @endfor
                        <th class="signature-cell"></th>
                    </tr>

                    @php
                        $uniqueParameters = collect();
                        foreach ($jobItem->samples as $sample) {
                            foreach ($sample->testResults as $result) {
                                if ($result->parameter) {
                                    $paramKey = $result->parameter->id;
                                    if (!$uniqueParameters->where('id', $paramKey)->count()) {
                                        $uniqueParameters->push([
                                            'id' => $paramKey,
                                            'name' => $result->parameter->code,
                                            'unit' => $result->parameter->unit,
                                        ]);
                                    }
                                }
                            }
                        }
                    @endphp

                    @foreach ($uniqueParameters as $parameter)
                        <tr>
                            <td class="number-cell">{{ $rowNumber }}</td>
                            <td class="parameter-cell">{{ $parameter['name'] }}</td>
                            <td class="unit-cell">{{ $parameter['unit'] }}</td>

                            @php
                                $sampleResults = [];
                                foreach ($jobItem->samples as $sample) {
                                    $result = $sample->testResults->where('parameter_id', $parameter['id'])->first();
                                    $sampleResults[] = $result ? $result->tested_value : '';
                                }
                            @endphp

                            @for ($i = 0; $i < $maxSamplesInMatrix; $i++)
                                @if ($i < count($sampleResults))
                                    <td class="result-cell">{{ $sampleResults[$i] }}</td>
                                @else
                                    <td class="result-cell" style="background-color: #f5f5f5;"></td>
                                @endif
                            @endfor

                            <td class="signature-cell"></td>
                        </tr>
                        @php $rowNumber++; @endphp
                    @endforeach

                    <tr style="height: 8px;">
                        <td colspan="{{ 3 + $maxSamplesInMatrix + 1 }}" style="border: none;"></td>
                    </tr>
                @endforeach

                {{-- Baris kosong utk entri tambahan manual --}}
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td class="number-cell"></td>
                        <td class="parameter-cell"></td>
                        <td class="unit-cell"></td>
                        @for ($j = 0; $j < $maxSamplesInMatrix; $j++)
                            <td class="result-cell"></td>
                        @endfor
                        <td class="signature-cell"></td>
                    </tr>
                @endfor
            </tbody>
        </table>

        {{-- Footer Tanda Tangan --}}
        <table class="footer-table">
            <tr>
                <td style="width: 33%;">
                    <div class="signature-name">Penyelia Lapangan</div>
                    <div><span class="date-line"></span></div>
                </td>
                <td style="width: 33%;">
                    <div class="signature-name">Tanggal</div>
                    <div><span class="date-line"></span></div>
                </td>
                <td style="width: 34%;">
                    <div class="signature-name">Tanda Tangan</div>
                    <div></div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
