<?php

namespace App\Filament\Resources\Invoices\Actions;

use App\Models\Enums\PaymentStatusEnum;
use App\Models\Payment;
use Auth;
use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class PaymentStatusAction
{
    protected static string $receiptPreviewUrl = 'payments.receipt.preview';
    protected static string $receiptDownloadUrl = 'payments.receipt.download';

    public const PERMISSION_PREVIEW_RECEIPT = 'preview-receipt';
    public const PERMISSION_DOWNLOAD_RECEIPT = 'download-receipt';

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }

    protected static function isReceiptAvailable(Payment $record): bool
    {
        return $record->status === PaymentStatusEnum::Completed->value
            && $record->receipt_number !== null;
    }

    /**
     * Preview Kuitansi Pembayaran PDF
     */
    public static function preview(): Action
    {
        return Action::make('PreviewReceipt')
            ->label('Preview Kuitansi')
            ->color(Color::Blue)
            ->icon(Heroicon::OutlinedDocumentDuplicate)
            ->slideOver()
            ->visible(
                fn(Payment $record): bool =>
                static::isReceiptAvailable($record)
            )
            // ->authorize(
            //     fn(Payment $record): bool =>
            //     static::isAuthorized(
            //         static::PERMISSION_PREVIEW_RECEIPT
            //     )
            // )
            ->modalHeading('Pratinjau Kuitansi Pembayaran')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup Pratinjau')
            ->modalWidth('6xl')
            ->modalContent(function (Payment $record)
            {
                $safeFileName = str_replace(
                    ['/', '\\', ':', '*', '?', '"', '<', '>', '|'],
                    '-',
                    $record->receipt_number
                );

                $pdfUrl = route(
                    static::$receiptPreviewUrl,
                    $record
                );

                $downloadUrl = route(
                    static::$receiptDownloadUrl,
                    $record
                );

                return view('pdfs.preview', [
                    'pdfUrl' => $pdfUrl,
                    'safeFileName' => $safeFileName,
                    'downloadUrl' => $downloadUrl,
                ]);
            })
            ->modalFooterActions([
                static::download(),
            ])
            ->modalFooterActionsAlignment('right');
    }

    /**
     * Download Kuitansi Pembayaran PDF
     */
    public static function download(): Action
    {
        return Action::make('DownloadReceipt')
            ->label('Download Kuitansi')
            ->visible(
                fn(Payment $record): bool =>
                static::isReceiptAvailable($record)
            )
            // ->authorize(
            //     fn(Payment $record): bool =>
            //     static::isAuthorized(
            //         static::PERMISSION_DOWNLOAD_RECEIPT
            //     )
            // )
            ->url(
                fn(Payment $record): string =>
                route(
                    static::$receiptDownloadUrl,
                    $record
                )
            )
            ->icon(Heroicon::OutlinedDocumentArrowDown)
            ->color('info')
            ->openUrlInNewTab();
    }
}
