<?php

namespace App\Filament\Resources\InvoiceResource\Actions;

use App\Filament\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Enums\InvoiceStatusEnum;
use Auth;
use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class InvoiceStatusAction
{
    protected static string $invoicePreviewUrl = 'invoices.preview_pdf';
    protected static string $invoiceDownloadUrl = 'invoices.download_pdf';

    public const PERMISSION_PREVIEW_INVOICE = 'preview-invoice';
    public const PERMISSION_DOWNLOAD_INVOICE = 'download-invoice';

    protected static function isAuthorized(string $permission): bool
    {
        return Auth::user()->can($permission);
    }

    /**
     * Preview Invoice PDF
     */
    public static function preview(): Action
    {
        return Action::make('Preview')
            ->label('Preview PDF')
            ->color(Color::Blue)
            ->icon(Heroicon::OutlinedDocumentDuplicate)
            ->slideOver()
            // ->authorize(
            //     static::isAuthorized(
            //         static::PERMISSION_PREVIEW_INVOICE
            //     )
            // )
            ->modalHeading('Pratinjau Invoice PDF')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup Pratinjau')
            ->modalWidth('6xl')
            ->modalContent(function (Invoice $record) {
                $safeFileName = str_replace(
                    ['/', '\\', ':', '*', '?', '"', '<', '>', '|'],
                    '-',
                    $record->code
                );

                $pdfUrl = route(
                    static::$invoicePreviewUrl,
                    $record
                );

                $downloadUrl = route(
                    static::$invoiceDownloadUrl,
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
     * Download Invoice PDF
     */
    public static function download(): Action
    {
        return Action::make('Download')
            ->label('Download PDF')
            ->authorize(
                fn(Invoice $record): bool =>
                static::isAuthorized(
                    static::PERMISSION_DOWNLOAD_INVOICE
                )
            )
            ->url(
                fn(Invoice $record): string =>
                route(
                    static::$invoiceDownloadUrl,
                    $record
                )
            )
            ->icon(Heroicon::OutlinedDocumentArrowDown)
            ->color("info")
            ->openUrlInNewTab();
    }
}
