<?php

namespace App\Providers\Filament;

use Filament\Pages\Dashboard;
use App\Filament\Resources\CustomerResource\Widgets\CustomerStatsChart;
use App\Filament\Resources\ParameterResource\Widgets\ParameterAccreditationChart;
use App\Filament\Resources\PersonelResource\Widgets\PersonnelRolesChart;
use App\Filament\Resources\QuotationResource\Widgets\QuotationStatusChart;
use App\Filament\Resources\ParameterResource\Widgets\TopParametersTable;
use App\Filament\Resources\TestPackageResource\Widgets\TopTestPackagesTable;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
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
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // TopTestPackagesTable::class,
                // TopParametersTable::class,
                ParameterAccreditationChart::class,
                QuotationStatusChart::class,
                PersonnelRolesChart::class,
                CustomerStatsChart::class,
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
            ])->path('lims')
            ->authMiddleware([
                Authenticate::class,
            ])->readOnlyRelationManagersOnResourceViewPagesByDefault(true)->databaseNotifications()->databaseNotificationsPolling(null);
    }
}
