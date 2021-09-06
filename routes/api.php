<?php

use App\Http\Controllers\GeoIp2\GeoIp2Controller;
use App\Jobs\GetGeoIp2DataJop;
use Illuminate\Support\Facades\Route;

    Route::get('/ip/run/{ip}',function ($ip){

        try {
            GetGeoIp2DataJop::dispatch($ip);
            return response([
                "geo_ip2"=>"job called"
            ],201);
        }catch (Exception $exception){
            return response([
                "error"=>$exception
            ],201);
        }

    });
