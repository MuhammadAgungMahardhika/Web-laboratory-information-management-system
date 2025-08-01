<x-mail::message>
{{ ucfirst($mailData['title']) }}

Terlampir adalah dokumen penawaran harga terbaru dari kami.
@if (isset($mailData) && $mailData['customerName'])
Yth. Bapak/Ibu {{ $mailData['customerName'] }},
@endif

@if (isset($mailData) && $mailData['quotationNumber'])
Ini berkaitan dengan Penawaran {{ $mailData['title'] }}
Nomor : {{ $mailData['quotationNumber'] }}
Judul : {{ $mailData['title'] }}.
@endif

@if (isset($mailData) && $mailData['message'])
{{ $mailData['message'] }}
@endif

<x-mail::panel>
Dokumen ini berisi rincian penawaran harga dan syarat-syarat yang berlaku.
Silakan tinjau dengan seksama.
Jika ada pertanyaan atau klarifikasi yang diperlukan, jangan ragu untuk menghubungi kami.
</x-mail::panel>

<x-mail::button :url="$mailData['downloadUrl'] ?? ''" color="success">
Download Penawaran PDF
</x-mail::button>

<x-mail::panel>
Jika Anda ingin mengunduh dokumen ini, silakan klik tombol di atas.
Dokumen akan tersedia dalam format PDF.
</x-mail::panel>

<x-mail::panel>
Terima kasih atas perhatian Anda.

Hormat kami,<br>
{{ config('app.name') }}
</x-mail::panel>
</x-mail::message>