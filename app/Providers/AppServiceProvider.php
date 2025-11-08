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
        // Register Review Policy
        Gate::policy(Review::class, ReviewPolicy::class);
        
        // Define admin-only gate
        Gate::define('admin-only', function ($user) {
            return $user->role && $user->role->name === 'admin';
        });
    }
}
