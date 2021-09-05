<?php

use App\Http\Controllers\GeoIp2\GeoIp2Controller;
use Illuminate\Support\Facades\Route;

Route::get('/ip/run/{ip}',function ($ip){

    $get = new GeoIp2Controller();
    $data = $get->get_location($ip);

    return response([
        "geo_ip2"=>$data
    ],201);
});
