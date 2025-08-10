<?php

namespace App\Listeners;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendQuotationNotification
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        try {
            // $event->data contains the raw payload from the queued job.
            $eventPayload = $event->data; // Renamed to $eventPayload for clarity
            $notifierId = data_get($eventPayload, 'notifierId'); // <-- PERBAIKAN DI SINI: ambil langsung dari root payload

            // Data lainnya ada di dalam array 'mailData' di dalam payload
            $mailDataFromPayload = data_get($eventPayload, 'mailData', []); // Ambil array mailData, default ke array kosong
            $quotationNumber = data_get($mailDataFromPayload, 'quotationNumber');
            $customerName = data_get($mailDataFromPayload, 'customerName');
            if ($notifierId) {
                $user = User::find($notifierId);
                if ($user) {
                    // To broadcast, the `broadcast()` method should be chained before `send()`.
                    // Note: `send()` is the final method that dispatches the notification.
                    Notification::make()
                        ->success()
                        ->title('Pengiriman Penawaran Berhasil!')
                        ->body('Penawaran #' . ($quotationNumber ?? 'N/A') . ' untuk ' . ($customerName ?? 'pelanggan') . ' berhasil dikirim via email.')
                        ->broadcast($user)
                        ->sendToDatabase($user)
                        ->send();
                }
            } else {
                // Log a warning if the notifierId is missing for debugging purposes.
                Log::warning('MessageSent Event: Could not find notifierId in the event payload. Cannot send user notification.');
            }
        } catch (\Throwable $th) {
            Log::warning('Failed running send quotation listener');
        }
    }
}
