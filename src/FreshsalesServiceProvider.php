<?php

namespace Gentor\Freshsales;

use Illuminate\Support\ServiceProvider;

/**
 * Class FreshsalesServiceProvider
 * @package Gentor\Freshsales
 */
class FreshsalesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('freshsales', function ($app) {
            return new FreshsalesService($app['config']['freshsales']);
        });
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