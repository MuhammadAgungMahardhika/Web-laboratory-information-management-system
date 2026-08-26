<?php

namespace App\Jobs;

use App\Models\SampleHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordSampleHistoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $history
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('RecordTestResultHistoryJob dijalankan');
        SampleHistory::create($this->history);
    }
}
