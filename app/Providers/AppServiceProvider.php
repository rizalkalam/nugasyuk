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
        // if ($request->server->has('HTTP_X_ORIGINAL_HOST')) {
        //     $this->app['url']->forceRootUrl($request->server->get('HTTP_X_FORWARDED_PROTO').'://'.$request->server->get('HTTP_X_ORIGINAL_HOST'));
        // }
    }
}
