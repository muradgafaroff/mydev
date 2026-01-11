<?php

namespace AZPayments\Kapitalbank;

use Illuminate\Support\ServiceProvider;
use AZPayments\Kapitalbank\Services\KapitalbankService;

class KapitalbankServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Config faylını birləşdir
        $this->mergeConfigFrom(
            __DIR__ . '/../config/kapitalbank.php',
            'kapitalbank'
        );

        // Singleton olaraq qeydiyyat
        $this->app->singleton('kapitalbank', function ($app) {
            return new KapitalbankService(
                config('kapitalbank')
            );
        });

        // Alias qeydiyyatı
        $this->app->alias('kapitalbank', KapitalbankService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Config publish
        $this->publishes([
            __DIR__ . '/../config/kapitalbank.php' => config_path('kapitalbank.php'),
        ], 'kapitalbank-config');

        // Migration publish
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'kapitalbank-migrations');
        }

        // Routes yüklə
        $this->loadRoutesFrom(__DIR__ . '/../routes/kapitalbank.php');

        // Artisan commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                // Commands buraya əlavə olunacaq
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['kapitalbank', KapitalbankService::class];
    }
}