<?php

namespace App\Providers;

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
        // register route middleware alias for admin checks
        if ($this->app->bound('router')) {
            $this->app['router']->aliasMiddleware('is_admin', \App\Http\Middleware\IsAdmin::class);
        }
    }
}
