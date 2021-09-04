<?php

use App\Http\Controllers\IpController;
use Illuminate\Support\Facades\Route;

Route::get('/ip/run/{ip}',function ($ip){

    $get = new IpController();
    $country = $get->get_location($ip);

    return response([
        "ip"=>$ip,
        "country"=>$country
    ],201);
});
