@php
    use App\Models\Enums\SampleHistoryActionEnum;
    use Illuminate\Support\Carbon;

    $record = $getRecord();

    $histories = $record->sampleHistories->sortBy('created_at')->values();

    $fieldLabels = [
        'status' => 'Status',
        'sample_code' => 'Kode Sampel',
        'sample_type' => 'Jenis Sampel',
        'sample_name' => 'Nama Sampel',
        'received_at' => 'Tanggal Diterima',
        'collection_date' => 'Tanggal Pengambilan',
        'personel_id' => 'Personel',
    ];
@endphp

@if ($histories->isEmpty())
    <span style="color:#9ca3af;font-size:12px;">
        Belum ada riwayat
    </span>
@else
    <div style="display:flex;flex-direction:column;">

        @foreach ($histories as $history)
            @php
                /** @var SampleHistoryActionEnum|null $actionEnum */
                $actionEnum = $history->action;

                $icon = $actionEnum?->icon() ?? '•';
                $label = $actionEnum?->label() ?? 'Riwayat';

                $color =
                    is_object($actionEnum) && method_exists($actionEnum, 'color') ? $actionEnum->color() : '#3b82f6';

                $personel = $history->personel?->fullname ?? '-';

                $date = $history->created_at ? Carbon::parse($history->created_at)->format('d M Y H:i') : '-';

                $changes = is_array($history->changes)
                    ? $history->changes
                    : json_decode((string) $history->changes, true);

                $changes = is_array($changes) ? $changes : [];
            @endphp

            <div style="display:flex;align-items:flex-start;">

                {{-- Timeline --}}
                <div
                    style="
                        width:18px;
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        margin-right:8px;
                    ">

                    {{-- Icon --}}
                    <div
                        style="
                            width:18px;
                            height:18px;
                            border-radius:50%;
                            background:{{ $color }};
                            color:#fff;
                            font-size:11px;
                            font-weight:bold;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            flex-shrink:0;
                        ">
                        {{ $icon }}
                    </div>

                    {{-- Line --}}
                    @unless ($loop->last)
                        <div
                            style="
                                width:2px;
                                flex:1;
                                min-height:20px;
                                background:#d1d5db;
                            ">
                        </div>
                    @endunless

                </div>

                {{-- Content --}}
                <div style="padding-bottom:12px;min-width:0;">

                    {{-- Action --}}
                    <div
                        style="
                            color:{{ $color }};
                            font-size:12px;
                            font-weight:600;
                        ">
                        {{ $label }}
                    </div>

                    {{-- Personel --}}
                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                        ">
                        {{ $personel }}
                    </div>

                    {{-- Date --}}
                    <div
                        style="
                            color:#9ca3af;
                            font-size:10px;
                        ">
                        {{ $date }}
                    </div>

                    {{-- Changes --}}
                    @if (!empty($changes))
                        <div
                            style="
                                margin-top:4px;
                                padding:6px 8px;
                                background:#f9fafb;
                                border-radius:4px;
                                color:#555;
                                font-size:11px;
                                line-height:1.5;
                            ">
                            @foreach ($changes as $field => $change)
                                <div>

                                    <span
                                        style="
                                            font-weight:600;
                                            color:#374151;
                                        ">
                                        {{ $fieldLabels[$field] ?? ucwords(str_replace('_', ' ', $field)) }}:
                                    </span>

                                    <span style="color:#9ca3af;">
                                        {{ $change['old'] ?? '-' }}
                                    </span>

                                    &rarr;

                                    <span style="font-weight:600;">
                                        {{ $change['new'] ?? '-' }}
                                    </span>

                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>

            </div>
        @endforeach

    </div>
@endif
