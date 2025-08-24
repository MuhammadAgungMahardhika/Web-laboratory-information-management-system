<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use Filament\Actions\EditAction;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Exception;
use Filament\Actions\ActionGroup;
use App\Filament\Resources\QuotationResource;
use App\Filament\Resources\QuotationResource\Actions\QuotationStatusAction;
use App\Mail\DocumentMail;
use App\Models\Enums\QuotationStatusEnum;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Quotation;
use App\Services\QuotationService;
use App\Services\WhatsAppService;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Filament\Support\Colors\Color;

class ViewQuotation extends ViewRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            QuotationStatusAction::preview(),
            ActionGroup::make([
                QuotationStatusAction::submitted(),
                QuotationStatusAction::accepted(),
                QuotationStatusAction::revised(),
                QuotationStatusAction::cancelled(),
            ])
                ->label('Update Status') // Label untuk tombol dropdown utama
                ->icon('heroicon-o-arrow-path')
                ->button()
                ->color('primary'),

        ];
    }
}
