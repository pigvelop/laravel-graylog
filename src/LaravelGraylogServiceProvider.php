<?php

namespace Pigvelop\LaravelGraylog;

use Illuminate\Support\ServiceProvider;
use Pigvelop\LaravelGraylog\Facades\LaravelGraylog as LaravelGraylogFacade;

class LaravelGraylogServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'pigvelop');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'pigvelop');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        // Push Monolog Handler if configured;
        LaravelGraylogFacade::pushHandler();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-graylog.php', 'laravel-graylog');

        // Register the service the package provides.
        $this->app->singleton('laravelgraylog', function ($app) {
            return new LaravelGraylog;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelgraylog'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-graylog.php' => config_path('laravel-graylog.php'),
        ], 'laravel-graylog.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/pigvelop'),
        ], 'laravelgraylog.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/pigvelop'),
        ], 'laravelgraylog.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/pigvelop'),
        ], 'laravelgraylog.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
