@php
    use App\Models\Enums\TestResultApprovalStatusEnum;
    use Illuminate\Support\Carbon;

    $record = $getRecord();

    $approvals = $record->testResultApprovals->sortBy('approval_level')->values();

    $latestApproval = $approvals->sortByDesc('updated_at')->first();

    $count = $approvals->count();
@endphp

@if (!$latestApproval)
    <span style="color:#9ca3af;font-size:12px;">
        Belum ada approval
    </span>
@else
    @php
        /** @var TestResultApprovalStatusEnum $status */
        $status = $latestApproval->status;

        $color = $status->color();
        $icon = $status->icon();
        $label = $status->label();
    @endphp


    <div style="line-height:1.4;">

        {{-- Status terakhir --}}
        <div
            style="
                font-size:12px;
                font-weight:700;
                color:#111827;
            ">
            <span
                style="
                    display:inline-flex;
                    align-items:center;
                    justify-content:center;
                    width:18px;
                    height:18px;
                    border-radius:50%;
                    background:{{ $color }};
                    color:#fff;
                    font-size:11px;
                    margin-right:4px;
                ">
                {{ $icon }}
            </span>

            Level {{ $latestApproval->approval_level }}
        </div>


        {{-- Status --}}
        <div
            style="
                color:{{ $color }};
                font-size:12px;
                font-weight:600;
            ">
            {{ $label }}
        </div>


        {{-- jumlah aktivitas --}}
        <div
            style="
                margin-top:4px;
                color:#2563eb;
                font-size:11px;
                font-weight:500;
            ">
            ({{ $count }} aktivitas)
        </div>

    </div>
@endif
