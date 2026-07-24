@php
    use App\Models\Enums\TestResultApprovalStatusEnum;
    use Illuminate\Support\Carbon;

    $record = $getRecord();
    $approvals = $record->testResultApprovals->sortBy('approval_level')->values();

    $previousApproved = true;
@endphp

@if ($approvals->isEmpty())
    <span style="color:#9ca3af;font-size:12px;">
        Belum ada approval
    </span>
@else
    <div style="display:flex;flex-direction:column;">

        @foreach ($approvals as $approval)
            @php
                /** @var TestResultApprovalStatusEnum $statusEnum */
                $statusEnum = $approval->status;

                if ($statusEnum === TestResultApprovalStatusEnum::Pending) {
                    if ($previousApproved) {
                        $color = $statusEnum->color();
                        $icon = $statusEnum->icon();
                        $status = $statusEnum->label();
                    } else {
                        $color = '#9ca3af';
                        $icon = '○';
                        $status = 'Belum Dimulai';
                    }
                } else {
                    $color = $statusEnum->color();
                    $icon = $statusEnum->icon();
                    $status = $statusEnum->label();
                }

                $personel = $approval->personel?->fullname ?? '-';

                $date = in_array(
                    $statusEnum,
                    [
                        TestResultApprovalStatusEnum::Accepted,
                        TestResultApprovalStatusEnum::Rejected,
                        TestResultApprovalStatusEnum::Revision,
                    ],
                    true,
                )
                    ? Carbon::parse($approval->updated_at)->format('d M Y H:i')
                    : '';
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
                            font-size:12px;
                            font-weight:600;
                            color:#111827;
                        ">
                        Level {{ $approval->approval_level }}
                    </div>

                    <div
                        style="
                            color:{{ $color }};
                            font-size:12px;
                            font-weight:600;
                        ">
                        {{ $status }}
                    </div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                        ">
                        {{ $personel }}
                    </div>

                    @if ($date)
                        <div
                            style="
                                color:#9ca3af;
                                font-size:10px;
                            ">
                            {{ $date }}
                        </div>
                    @endif

                    @if (in_array($statusEnum, [TestResultApprovalStatusEnum::Rejected, TestResultApprovalStatusEnum::Revision], true) &&
                            filled($approval->note))
                        <div
                            style="
                                margin-top:4px;
                                padding:6px 8px;
                                background:#f9fafb;
                                border-radius:4px;
                                color:#555;
                                font-size:11px;
                                line-height:1.4;
                            ">
                            {{ $approval->note }}
                        </div>
                    @endif

                </div>

            </div>

            @php
                $previousApproved = $statusEnum === TestResultApprovalStatusEnum::Accepted;
            @endphp
        @endforeach

    </div>
@endif
