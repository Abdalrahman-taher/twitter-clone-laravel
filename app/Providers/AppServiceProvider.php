<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        View::composer('home.left-sidebar', function ($view) {
            $unreadNotificationsCount = 0;

            if (auth()->check()) {
                $unreadNotificationsCount = auth()
                    ->user()
                    ->notifications()
                    ->whereNull('read_at')
                    ->count();
            }

            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        });
    }
}
