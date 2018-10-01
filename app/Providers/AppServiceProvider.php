<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\System\Utils\CurrencyConverter;
use App\System\Importers\CurrencyRateImporter;
use App\System\StatisticsGenerator\StatisticsGenerator;
use App\System\NotificationGenerator\NotificationGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CurrencyConverter::class, function($app) {
            return new CurrencyConverter();
        });

        $this->app->singleton(StatisticsGenerator::class, function($app) {
            $currencyConverter = $app->make(CurrencyConverter::class);
            return new StatisticsGenerator($currencyConverter);
        });

        $this->app->singleton(CurrencyRateImporter::class, function($app) {
            return new CurrencyRateImporter();
        });
    }
}
