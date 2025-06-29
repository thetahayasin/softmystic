<?php

namespace App\Providers\Filament;

use App\Http\Middleware\CheckIfAppInstalled;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use App\Http\Middleware\EnsureUserIsActive;
use App\Models\SiteSetting;
use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Schema;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        
        try {
            if (
                app()->runningInConsole() === false &&
                config('app.installed') &&
                \Illuminate\Support\Facades\Schema::hasTable('site_settings')
            ) {
                $siteLogo = \App\Models\SiteSetting::first()?->site_logo;
                $siteFavicon = \App\Models\SiteSetting::first()?->site_favicon;
            } else {
                $siteLogo = null;
                $siteFavicon = null;
            }
        } catch (\Throwable $e) {
            $siteLogo = null;
            $siteFavicon = null;
        }


        return $panel
            ->default()
            ->id('admin')
            ->brandLogo($siteLogo ? asset('storage/' . $siteLogo) : null)
            ->favicon(asset($siteLogo ? asset('storage/' . $siteFavicon) : null))
            ->path('mystic')
            ->login()
            ->navigationGroups([
                'Content Management',
                'Content Settings',
            ])
            ->colors([
                'primary' => Color::Pink,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
                CheckIfAppInstalled::class,
                EnsureUserIsActive::class
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
