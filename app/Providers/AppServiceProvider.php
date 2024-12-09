<?php

namespace App\Providers;

use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Models\BarangMasuk;
use App\Observers\BarangMasukObserver;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        FilamentView::registerRenderHook('panels::body.end', fn(): string => Blade::render("@vite('resources/js/app.js')"));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Authenticate::redirectUsing(fn(): string => Filament::getLoginUrl());
        AuthenticateSession::redirectUsing(
            fn(): string => Filament::getLoginUrl()
        );
        AuthenticationException::redirectUsing(
            fn(): string => Filament::getLoginUrl()
        );

        // Navigation Top User Card
        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_NAV_START,
            fn(): View => view('filament.user-card')
        );

        // Footer
        FilamentView::registerRenderHook(
            PanelsRenderHook::FOOTER,
            fn(): View => view('filament.footer'),
            // Render The Footer for Pages or Resource
            scopes: [
                Dashboard::class,
                UserResource::class,
                RoleResource::class,
            ]
        );

        // Vite Hot Reloading
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn(): string => Blade::render("@vite('resources/js/app.js')")
        );

        BarangMasuk::observe(BarangMasukObserver::class);
    }
}
