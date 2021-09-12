<?php

namespace App\Providers\ExternalServices;

use App\Services\Contracts\GeoLocationContract;
use App\Services\GeoIp2Service\GeoIp2Service;
use Illuminate\Support\ServiceProvider;

class GeoLocationServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(GeoLocationContract::class,GeoIp2Service::class);
    }

}
