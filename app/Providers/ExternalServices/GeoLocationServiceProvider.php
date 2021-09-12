<?php

namespace App\Providers\ExternalServices;

use App\Services\Contracts\GeoLocationContract;
use App\Services\GeoIp2Service\GeoIp2Service;
use Illuminate\Support\ServiceProvider;

class GeoLocationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GeoLocationContract::class,GeoIp2Service::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
