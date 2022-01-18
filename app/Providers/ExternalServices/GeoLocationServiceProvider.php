<?php

namespace App\Providers\ExternalServices;


use App\ExternalServices\Contracts\GeoLocationContract;
use App\ExternalServices\GeoIp2Service\GeoIp2Service;
use Illuminate\Support\ServiceProvider;

class GeoLocationServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(GeoLocationContract::class,GeoIp2Service::class);
    }

}
