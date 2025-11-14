<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Review;
use App\Policies\ReviewPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default locale to Indonesian
        app()->setLocale('id');
        
        // Register Review Policy
        Gate::policy(Review::class, ReviewPolicy::class);
        
        // Define admin-only gate
        Gate::define('admin-only', function ($user) {
            return $user->role && $user->role->name === 'admin';
        });
        
        // Define owner-only gate
        Gate::define('owner-only', function ($user) {
            return $user->role && $user->role->name === 'owner';
        });
        
        // Set pagination to Indonesian
        \Illuminate\Pagination\Paginator::useBootstrap();
        
        // Ensure asset URLs are absolute in production
        if (app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            // Ensure APP_URL is set correctly for absolute URLs
            if (config('app.url')) {
                \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
            }
        }
    }
}
