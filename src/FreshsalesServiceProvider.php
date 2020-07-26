<?php

namespace Gentor\Freshsales;

use Illuminate\Support\ServiceProvider;

/**
 * Class FreshsalesServiceProvider
 * @package Gentor\Freshsales
 */
class FreshsalesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/freshsales.php' => config_path('freshsales.php'),
        ], 'config');

        $this->app->bind('freshsales', function ($app) {
            return new FreshsalesService($app['config']['freshsales']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/freshsales.php', 'freshsales');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['freshsales'];
    }
}