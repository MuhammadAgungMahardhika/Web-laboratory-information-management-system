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
        }

        .footer-wrap {
            display: table;
            width: 100%;
            height: 14mm;
        }

        .footer-image {
            display: table-cell;
            width: 88%;
            vertical-align: middle;
        }

        .footer-image img {
            width: 100%;
            height: 14mm;
            object-fit: cover;
            display: block;
        }

        .footer-page {
            display: table-cell;
            width: 12%;
            vertical-align: middle;
            text-align: center;
            border: 2px solid #333;
            font-weight: bold;
            font-size: 11pt;
            background: white;
        }
    </style>
</head>

<body>
    <div class="footer-wrap">
        <div class="footer-image">
            @php
                $footerPath = $company->active_setting?->footer_path ?? public_path('images/quotation-footer.png');

                // Jika footer_path adalah relative storage path
                if ($company->active_setting?->footer_path) {
                    $footerPath = public_path('storage/' . $company->active_setting->footer_path);
                }

                $footerBase64 = '';
                if (file_exists($footerPath)) {
                    $footerData = file_get_contents($footerPath);
                    $footerType = pathinfo($footerPath, PATHINFO_EXTENSION);
                    $footerBase64 = 'data:image/' . $footerType . ';base64,' . base64_encode($footerData);
                }
            @endphp
            @if ($footerBase64)
                <img src="{{ $footerBase64 }}" alt="Footer">
            @endif
        </div>
        {{-- Nomor halaman wkhtmltopdf: [page] dan [toPage] diganti otomatis --}}
        <div class="footer-page">
            <span class="page">{{ '[page]' }}</span> / <span class="topage">{{ '[toPage]' }}</span>
        </div>
    </div>
</body>

</html>
