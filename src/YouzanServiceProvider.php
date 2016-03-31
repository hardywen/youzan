<?php

namespace Hardywen\Youzan;


use Illuminate\Support\ServiceProvider;

class YouzanServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $config = realpath(__DIR__ . '/../config/youzan.php');

        $this->mergeConfigFrom($config, 'youzan');

        $this->publishes([
            $config                              => config_path('youzan.php'),
            __DIR__ . '/../database/migrations/' => database_path('migrations')

        ]);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['youzan'] = $this->app->share(function ($app) {
            $config = $app['config']['youzan'];
            return new YouzanSdk($config);
        });
    }
}