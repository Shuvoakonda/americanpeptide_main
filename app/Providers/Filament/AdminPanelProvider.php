<?php

namespace App\Providers\Filament;

use Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminPanelAccess;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::hex('#9B8B7A'), // Dusty rose
                'secondary' => Color::hex('#A8B5A0'), // Sage green
                'success' => Color::hex('#8BA892'), // Muted green
                'danger' => Color::hex('#B87A7A'), // Muted red
                'warning' => Color::hex('#D4B483'), // Muted gold
                'info' => Color::hex('#8BA8B5'), // Muted blue
                'light' => Color::hex('#FAF9F7'), // Soft cream
                'dark' => Color::hex('#4A3F35'), // Dark text
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\SalesOverview::class,
                \App\Filament\Widgets\SalesChart::class,
                \App\Filament\Widgets\RecentOrdersTable::class,
                \App\Filament\Widgets\TopProducts::class,
                \App\Filament\Widgets\LowStockAlert::class,
            ])
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
                AdminPanelAccess::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentMenuBuilderPlugin::make()->addLocations([
                'main' => 'Main Menu',
                'mobile' => 'Mobile Menu',
                'footer_1' => 'Footer Menu 1',
                'footer_2' => 'Footer Menu 2',
            ]));
    }
}
