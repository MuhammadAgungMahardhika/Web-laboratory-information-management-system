<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
        }

        .header-wrap {
            padding: 5px 0 0 0;
        }

        .header-wrap img {
            max-width: 100%;
            display: block;
        }

        .header-quotation-info {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            text-align: center;
            font-size: 10pt;
            margin-top: 4px;
        }

        .header-quotation-info td {
            padding: 2px 4px;
        }

        .header-quotation-info tr:first-child td {
            background-color: #bedff3;
            font-size: 14pt;
            font-weight: bold;
            padding: 4px;
        }
    </style>
</head>

<body>
    <div class="header-wrap">
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
            <img src="{{ $korpBase64 }}" alt="Kop Surat">
        @endif

        <table class="header-quotation-info">
            <tr>
                <td><strong>Quotation Letter</strong></td>
            </tr>
            <tr>
                <td>No.Quo: {{ $quotation->code }}</td>
            </tr>
            <tr>
                <td><strong>{{ $quotation->customer->name }}</strong></td>
            </tr>
            <tr>
                <td>{{ $quotation->customer->full_address }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
