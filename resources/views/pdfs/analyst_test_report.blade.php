<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Lembar Laporan Pengujian Analisis (LPA)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 15px;
            line-height: 1.2;
        }

        .header-logos {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .logo-left,
        .logo-center,
        .logo-right {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .logo-left {
            width: 30%;
        }

        .logo-center {
            width: 40%;
            font-weight: bold;
            font-size: 12px;
        }

        .logo-right {
            width: 30%;
        }

        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin: 15px 0;
            border: 2px solid #000;
            padding: 8px;
            background-color: #f8f8f8;
        }

        .header-info {
            margin-bottom: 15px;
            font-size: 9px;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 2px 5px;
            border: none;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin-bottom: 10px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: start;
            vertical-align: middle;
        }

        .main-table th {
            background-color: #e8e8e8;
            font-weight: bold;
            font-size: 8px;
        }

        .group-header {
            background-color: #d0d0d0;
            font-weight: bold;
            text-align: start;
            font-size: 9px;
        }

        .subgroup-header {
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: center;
            font-size: 8px;
        }

        .parameter-cell {
            text-align: left;
            padding-left: 8px;
            font-size: 8px;
        }

        .number-cell {
            text-align: center;
            width: 20px;
            font-size: 8px;
        }

        .unit-cell {
            text-align: center;
            width: 40px;
            font-size: 8px;
        }

        .result-cell {
            text-align: center;
            width: 60px;
            font-size: 8px;
        }

        .signature-cell {
            width: 50px;
            text-align: center;
        }

        .footer-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .footer-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 9px;
            height: 60px;
            vertical-align: bottom;
        }

        .signature-name {
            margin-bottom: 30px;
            font-weight: bold;
        }

        .date-line {
            border-bottom: 1px solid #000;
            width: 100px;
            display: inline-block;
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <!-- Header with logos -->
    <div class="header-logos">
        <div class="logo-left">
            @if ($company && $company->logo)
                <img src="{{ public_path('storage/' . $company->logo) }}" style="height: 50px;">
            @endif
        </div>
        <div class="logo-center">
            LABORATORIUM PENGUJI LINGKUNGAN DAN PANGAN<br>
            {{ $company->name ?? 'NAMA PERUSAHAAN' }}<br>
            <small>{{ $company->address ?? 'ALAMAT PERUSAHAAN' }}</small>
        </div>
        <div class="logo-right">
            <!-- Logo akreditasi/sertifikasi -->
        </div>
    </div>

    <div class="header-title">
        LEMBAR LAPORAN PENGUJIAN ANALISIS (LPA)
    </div>

    <!-- Header Info -->
    <table class="info-table">
        <tr>
            <td class="info-label">Job Number</td>
            <td>: {{ $labJob->job_number }}</td>
            <td class="info-label">Tanggal Uji</td>
            <td>: {{ $labJob->test_date ?? '___________' }}</td>
        </tr>
        <tr>
            <td class="info-label">Bahan Produk</td>
            <td>: @foreach ($labJob->labJobItems as $item)
                    {{ $item->description }}@if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </td>
            <td class="info-label">Tanggal TAT</td>
            <td>: {{ $labJob->tat_date ?? '___________' }}</td>
        </tr>
        <tr>
            <td class="info-label">Jumlah Contoh Uji</td>
            <td>: @foreach ($labJob->labJobItems as $item)
                    {{ $item->samples()->count() }}@if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </td>
            <td class="info-label">Keterangan Lain</td>
            <td>: @php
                use App\Models\Enums\SampleCollectionTypeEnum;
                $collectionTypes = [];
                foreach ($labJob->labJobItems as $item) {
                    foreach ($item->samples as $sample) {
                        if ($sample->collection_type) {
                            $typeLabel = SampleCollectionTypeEnum::labels()[$sample->collection_type];
                            if (isset($collectionTypes[$typeLabel])) {
                                $collectionTypes[$typeLabel]++;
                            } else {
                                $collectionTypes[$typeLabel] = 1;
                            }
                        }
                    }
                }

                $formattedTypes = [];
                foreach ($collectionTypes as $type => $count) {
                    $formattedTypes[] = $type . ' (' . $count . ')';
                }
            @endphp
                {{ implode(', ', $formattedTypes) }}</td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="2" class="number-cell">No</th>
                <th rowspan="2" style="width: 200px;">Parameter</th>
                <th rowspan="2" class="unit-cell">Satuan</th>
                @php
                    $maxSamplesInMatrix = 0;
                    foreach ($labJob->labJobItems as $item) {
                        $sampleCount = $item->samples()->count();
                        if ($sampleCount > $maxSamplesInMatrix) {
                            $maxSamplesInMatrix = $sampleCount;
                        }
                    }
                @endphp
                <th colspan="{{ $maxSamplesInMatrix }}">Hasil Uji</th>
                <th rowspan="2" class="signature-cell">Paraf</th>
            </tr>
            <tr>
                <th class="result-cell" colspan="{{ $maxSamplesInMatrix }}"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $rowNumber = 1;
            @endphp

            @foreach ($labJob->labJobItems as $jobItem)
                <!-- Matrix Header -->
                <tr>
                    <td colspan="{{ 3 + $maxSamplesInMatrix + 1 }}" class="group-header">
                        {{ strtoupper($jobItem->description) }}
                    </td>
                </tr>

                <!-- Sub Header for Sample Numbers specific to this matrix -->
                <tr>
                    <th class="number-cell"></th>
                    <th style="width: 200px;"></th>
                    <th class="unit-cell"></th>
                    @php
                        $currentMatrixSampleCount = $jobItem->samples()->count();
                    @endphp
                    @for ($i = 1; $i <= $currentMatrixSampleCount; $i++)
                        <th class="result-cell subgroup-header">{{ $i }} / {{ $currentMatrixSampleCount }}
                        </th>
                    @endfor
                    @for ($i = $currentMatrixSampleCount + 1; $i <= $maxSamplesInMatrix; $i++)
                        <th class="result-cell" style="background-color: #f5f5f5;">-</th>
                    @endfor
                    <th class="signature-cell"></th>
                </tr>

                @php
                    // Collect unique parameters for this job item
                    $uniqueParameters = collect();
                    foreach ($jobItem->samples as $sample) {
                        foreach ($sample->testResults as $result) {
                            if ($result->parameter) {
                                $paramKey = $result->parameter->id;
                                if (!$uniqueParameters->where('id', $paramKey)->count()) {
                                    $uniqueParameters->push([
                                        'id' => $paramKey,
                                        'name' => $result->parameter->name,
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
                            // Get results for this parameter from this specific job item's samples
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

                <!-- Add some spacing between matrices -->
                <tr style="height: 10px;">
                    <td colspan="{{ 3 + $maxSamplesInMatrix + 1 }}" style="border: none;"></td>
                </tr>
            @endforeach

            <!-- Empty rows for additional entries -->
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

    <!-- Footer Signature Section -->
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
</body>

</html>
