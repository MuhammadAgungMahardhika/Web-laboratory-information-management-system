<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\CustomerStatsChart;
use App\Filament\Widgets\DynamicQuotationStatusChart;
use App\Filament\Widgets\PersonnelRolesChart;
use App\Filament\Widgets\QuotationStatusChart;
use App\Filament\Widgets\TopParametersTable;
use App\Filament\Widgets\TopTestPackagesTable;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SuperadminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('superadmin')
            ->path('superadmin')
            ->profile(isSimple: false)
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                QuotationStatusChart::class,
                PersonnelRolesChart::class,
                CustomerStatsChart::class,
                TopTestPackagesTable::class,
                TopParametersTable::class
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Master')
                    ->icon('heroicon-o-folder')->collapsed(),
                NavigationGroup::make()
                    ->label('Master Pengguna')
                    ->icon('heroicon-o-users')->collapsed(),
                NavigationGroup::make()
                    ->label('Master Lokasi')
                    ->icon('heroicon-o-map-pin')->collapsed(),
                NavigationGroup::make()
                    ->label('Transaksi')
                    ->icon('heroicon-o-arrows-right-left')->collapsed(),
            ])->sidebarCollapsibleOnDesktop(true)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->readOnlyRelationManagersOnResourceViewPagesByDefault(true)->databaseNotifications()->databaseNotificationsPolling(null);
    }
}
