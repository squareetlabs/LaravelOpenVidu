<?php

namespace SquareetLabs\LaravelOpenVidu\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SquareetLabs\LaravelOpenVidu\Cache\SessionStore;
use SquareetLabs\LaravelOpenVidu\OpenVidu;

/**
 * Class OpenViduServiceProvider
 * @package SquareetLabs\LaravelOpenVidu\Providers
 */
class OpenViduServiceProvider extends ServiceProvider
{
    /**
     * Register.
     */
    public function register()
    {
        $this->app->singleton(OpenVidu::class, function () {
            return new OpenVidu(/** @scrutinizer ignore-call */ config('services.openvidu'));
        });

        $this->app->alias(OpenVidu::class, 'openVidu');
        //Default parameter added true due to the compatibility
        if (config('services.openvidu.use_routes', true)) {
            $this->registerRoutes();
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        });
    }

    /**
     * Get the SmsUp route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'domain' => null,
            'namespace' => 'SquareetLabs\LaravelOpenVidu\Http\Controllers',
            'prefix' => 'openvidu'
        ];
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

            $this->publishes([
                __DIR__.'/../../database/migrations' => /** @scrutinizer ignore-call */ database_path('migrations'),
            ], 'openvidu-migrations');

        }
        Cache::extend('openvidu', function () {
            return Cache::repository(new SessionStore(DB::connection(), /** @scrutinizer ignore-call */ config('cache.stores.openvidu.table')));
        });
    }
}
