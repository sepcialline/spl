<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const ADMIN = '/admin';
    public const VENDOR = '/vendor';
    public const RIDER = '/rider';
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                // ->middleware('web')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            Route::middleware('api')
                // ->middleware('web')
                ->prefix('v1/api')
                ->group(base_path('routes/v1/api.php'));
            Route::middleware('web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath')
                ->prefix(LaravelLocalization::setLocale())
                ->group(base_path('routes/admin.php'));
            Route::middleware('web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath')
                ->prefix(LaravelLocalization::setLocale())
                ->group(base_path('routes/vendor.php'));
            // Route::middleware('web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath')
            //     ->prefix(LaravelLocalization::setLocale())
            //     ->group(base_path('routes/rider.php'));
            Route::middleware('web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath')
                ->prefix(LaravelLocalization::setLocale())
                ->group(base_path('routes/employee.php'));
            Route::middleware('web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath')
                ->prefix(LaravelLocalization::setLocale())
                ->group(base_path('routes/web.php'));
        });
    }
}
