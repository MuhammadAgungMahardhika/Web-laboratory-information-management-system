<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Label Sampel</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .label {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 8px;
            font-family: Arial, sans-serif;
            font-size: 8px;
            line-height: 1.2;
            border: 1px solid #0000;
            /* hapus saat produksi */
        }

        .title {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 4px;
        }

        .field {
            margin: 1px 0;
        }

        .barcode {
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <div class="label">
        <p class="title">PT. Jambi Lestari International</p>
        <p class="field">Tanggal pengambilan: {{ $sample->received_date ?? '-' }}</p>
        <p class="field">Tanggal penerimaan: {{ $sample->collection_date ?? '-' }}</p>
        <p class="field">Nomor Job: {{ $sample->labJobItem->labJob->job_number ?? '-' }}</p>
        <p class="field">Kode Sampel: {{ $sample->sample_code ?? '-' }}</p>
        <p class="field">Deskripsi Item: {{ $sample->labJobItem->description ?? '-' }}</p>

        {{-- Barcode (aktifkan kalau sudah pakai milon/barcode) --}}
        {{-- 
            <div class="barcode">
                {!! DNS1D::getBarcodeHTML($sample->sample_code, 'C39', 1, 40) !!}
            </div> 
            --}}
    </div>
    {{-- <div style="page-break-after: always;"></div> --}}
</body>

</html>
