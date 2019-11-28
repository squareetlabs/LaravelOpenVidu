<?php

namespace SquareetLabs\LaravelOpenVidu\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SquareetLabs\LaravelOpenVidu\Events\SessionDeleted;
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
        $this->app->singleton(OpenVidu::class, function ($app) {
            return new OpenVidu(config('services.openvidu'));
        });

        $this->app->alias(OpenVidu::class, 'openVidu');
        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
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
        Event::listen(
            SessionDeleted::class,
            OpenVidu::class
        );
    }
}
