@php
    use App\Models\Enums\TestResultHistoryActionEnum;
    use Illuminate\Support\Carbon;

    $record = $getRecord();
    $histories = $record->testResultHistories->sortByDesc('created_at')->values();

    $fieldLabels = [
        'status' => 'Status',
        'tested_value' => 'Nilai Uji',
        'comment' => 'Catatan',
        'evaluation_status' => 'Status Evaluasi',
        'validator_personel_id' => 'Validator',
        'analyst_personel_id' => 'Analis',
        'test_date' => 'Tanggal Uji',
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
                /** @var TestResultHistoryActionEnum|null $actionEnum */
                $actionEnum = $history->action;

                $icon = $actionEnum?->icon() ?? '•';
                $label = $actionEnum?->label() ?? 'Riwayat';
                $color =
                    is_object($actionEnum) && method_exists($actionEnum, 'color') ? $actionEnum->color() : '#3b82f6';

                $personel = $history->personel?->fullname ?? '-';
                $date = Carbon::parse($history->created_at)->format('d M Y H:i');

                $changes = is_array($history->changes)
                    ? $history->changes
                    : json_decode((string) $history->changes, true);

                $changes = is_array($changes) ? $changes : [];
            @endphp

            <div style="display:flex;align-items:flex-start;">

                <div
                    style="
                        width:18px;
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        margin-right:8px;
                    ">

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
                        ">
                        {{ $icon }}
                    </div>

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

                <div style="padding-bottom:12px;">

                    <div
                        style="
                            color:{{ $color }};
                            font-size:12px;
                            font-weight:600;
                        ">
                        {{ $label }}
                    </div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                        ">
                        {{ $personel }}
                    </div>

                    <div
                        style="
                            color:#9ca3af;
                            font-size:10px;
                        ">
                        {{ $date }}
                    </div>

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
                                    <span style="font-weight:600;color:#374151;">
                                        {{ $fieldLabels[$field] ?? ucwords(str_replace('_', ' ', $field)) }}:
                                    </span>
                                    <span style="color:#9ca3af;">{{ $change['old'] ?? '-' }}</span>
                                    &rarr;
                                    <span style="font-weight:600;">{{ $change['new'] ?? '-' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (filled($history->comment))
                        <div
                            style="
                                margin-top:4px;
                                padding:6px 8px;
                                background:#fffbeb;
                                border-radius:4px;
                                color:#92400e;
                                font-size:11px;
                                line-height:1.4;
                            ">
                            {{ $history->comment }}
                        </div>
                    @endif

                </div>

            </div>
        @endforeach

    </div>
@endif
