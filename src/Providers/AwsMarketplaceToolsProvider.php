<?php

namespace Shei\AwsMarketplaceTools\Providers;

use Illuminate\Support\ServiceProvider;

class AwsMarketplaceToolsProvider extends ServiceProvider
{
    public function register () {
        $this->mergeConfigFrom(__DIR__ . "/../config/config.php", "awsPackage");
    }

    public function boot () : void {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . "/../config/config.php" => config_path("awsPackage.php"),
            ], "config");
        }
    }
}
