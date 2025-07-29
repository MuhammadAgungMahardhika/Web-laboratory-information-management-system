<x-mail::message>
    # Penawaran Harga Baru

    Terlampir adalah dokumen penawaran harga terbaru dari kami.

    @if(isset($mailData) && $mailData['customerName'])
    Yth. Bapak/Ibu {{ $mailData['customerName'] }},
    @endif

    @if(isset($mailData) && $mailData['quotationNumber'])
    Ini berkaitan dengan Penawaran Harga Nomor: **{{ $mailData['quotationNumber'] }}**.
    @endif

    @if(isset($mailData) && $mailData['message'])
    {{ $mailData['message']}}
    @endif

    Mohon tinjau dokumen terlampir. Jika ada pertanyaan atau Anda memerlukan bantuan lebih lanjut, jangan ragu untuk membalas email ini atau menghubungi kami.

    <x-mail::button :url="$mailData['downloadUrl'] ?? ''">
    Download Penawaran PDF
    </x-mail::button>

    Jika tombol di atas tidak berfungsi, Anda bisa mengunduh dokumen langsung dari: [{{ $mailData['downloadUrl'] ?? '' }}]({{ $mailData['downloadUrl'] ?? '' }})

    Terima kasih atas perhatian Anda.

    Hormat kami,<br>
    {{ config('app.name') }}
</x-mail::message>
