<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Review;
use App\Models\UmkmProfile;
use Illuminate\Support\Facades\View;
use App\Policies\BannerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\UmkmPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\App\Services\UmkmService::class);
        $this->app->singleton(\App\Services\ProductService::class);
        $this->app->singleton(\App\Services\AnalyticsService::class);
        $this->app->singleton(\App\Services\MapService::class);
        $this->app->singleton(\App\Services\StatisticsService::class);
    }

    public function boot(): void
    {
        // Set default locale for Carbon
        Carbon::setLocale('id');

        // Use Tailwind CSS for pagination
        Paginator::defaultView('components.pagination');

        // Register policies
        Gate::policy(UmkmProfile::class, UmkmPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Banner::class, BannerPolicy::class);
        Gate::policy(Review::class, ReviewPolicy::class);

        // Real database-backed metrics for auth and account recovery pages.
        View::composer([
            'auth.login',
            'auth.register',
            'auth.forgot-password',
            'auth.reset-password',
            'auth.verify-otp',
        ], function ($view) {
            $totalUmkm = UmkmProfile::count();
            $verifiedUmkm = UmkmProfile::whereIn('verification_status', ['terverifikasi', 'aktif'])->count();
            $activeProducts = Product::where('is_active', true)
                ->whereHas('umkmProfile', fn ($query) => $query->active())
                ->count();

            $view->with('authStats', [
                'umkmRegistered' => $totalUmkm,
                'activeProducts' => $activeProducts,
                'verificationRate' => $totalUmkm > 0 ? (int) round(($verifiedUmkm / $totalUmkm) * 100) : 0,
            ]);
        });

        // Share site settings with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = \App\Models\SiteSetting::all()->pluck('value', 'key')->toArray();
            $view->with('siteSettings', $settings);
        });
    }
}
