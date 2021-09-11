<?php

use App\Http\Controllers\GeoIp2\GeoIp2Controller;
use App\Jobs\GetGeoIp2DataJop;
use Illuminate\Support\Facades\Route;

    Route::get('/ip/run/{ip}',function ($ip){

        GetGeoIp2DataJop::dispatch($ip);
            return response([
            "geo_ip2"=>"job called",
            "ip"=>$ip
        ],201);
    });
