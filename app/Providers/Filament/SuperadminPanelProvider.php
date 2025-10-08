<?php

namespace App\Providers\Filament;

use Filament\Pages\Dashboard;

use App\Filament\Widgets\CustomerStatsChart;
use App\Filament\Widgets\LabJobsChartWidget;
use App\Filament\Widgets\ParameterAccreditationChart;
use App\Filament\Widgets\PersonnelRolesChart;
use App\Filament\Widgets\QuotationsChartWidget;
use App\Filament\Widgets\SamplesChartWidget;
use App\Filament\Widgets\TestResultsChartWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
            ->spa()
            ->id('superadmin')
            ->path('superadmin')
            ->profile(isSimple: false)
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // TopTestPackagesTable::class,
                // TopParametersTable::class,
                QuotationsChartWidget::class,
                LabJobsChartWidget::class,
                SamplesChartWidget::class,
                TestResultsChartWidget::class,
                ParameterAccreditationChart::class,
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
