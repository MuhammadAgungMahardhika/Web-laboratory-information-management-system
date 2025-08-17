<?php

namespace App\Providers\Filament;

use Filament\Pages\Dashboard;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets(ResourcesRegistry::getAllWidgets())
            ->resources(ResourcesRegistry::getAllResources())
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
              ->authMiddleware([
                Authenticate::class,
            ])->readOnlyRelationManagersOnResourceViewPagesByDefault(true)->databaseNotifications()->databaseNotificationsPolling(null);
    }
}
