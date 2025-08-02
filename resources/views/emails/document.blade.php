<x-mail::message>
{{ ucfirst($mailData['title']) }}
<x-mail::panel>
@if (isset($mailData) && $mailData['message'])
{!! $mailData['message'] !!},
@endif
</x-mail::panel>
<x-mail::button :url="$mailData['downloadUrl'] ?? ''" color="success">
Download Penawaran PDF
</x-mail::button>
</x-mail::message>
