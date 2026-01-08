<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('create-schedule', function ($user) {
            return in_array($user->role, ['rg','se', 'admin']);
        });

        Gate::define('view-users', function ($user) {
            return in_array($user->role, ['rg', 'admin']);
        });
    }
}
