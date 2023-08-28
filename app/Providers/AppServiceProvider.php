<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('user', function(User $user) {
            return auth()->user()->role->name === 'user';
        });

        Gate::define('admin', function(User $user) {
            return auth()->user()->role->name === 'admin';
        });

        Gate::define('superadmin', function(User $user) {
            return auth()->user()->role->name === 'super-admin';
        });
    }
}