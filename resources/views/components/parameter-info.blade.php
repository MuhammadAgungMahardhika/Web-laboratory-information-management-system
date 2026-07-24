@php
    use App\Models\Enums\TestResultStatusEnum;
    use App\Models\Enums\TestResultApprovalStatusEnum;

    $status = TestResultStatusEnum::labels()[$record->status];
    $color = TestResultStatusEnum::cssColor($record->status);

    $pending = $record->testResultApprovals
        ->where('status', TestResultApprovalStatusEnum::Pending->value)
        ->sortBy('approval_level')
        ->first();
@endphp

<div style="display:flex;flex-direction:column;gap:4px;">

    <div style="font-weight:600;">
        {{ $record->parameter->long_name }}
    </div>

    <div style="font-size:12px;color:#6B7280;">
        {{ $record->testMethod?->name ?? '-' }}
    </div>

    <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">

        <span
            style="
                display:inline-block;
                padding:2px 10px;
                border-radius:999px;
                font-size:11px;
                font-weight:600;
                color:white;
                background:{{ $color }};
            ">
            {{ $status }}
        </span>

        @if ($pending)
            <span style="font-size:11px;color:#6B7280;">
                Menunggu Level {{ $pending->approval_level }}
            </span>
        @endif

    </div>

</div>
