<?php

use App\Http\Controllers\IpController;
use Illuminate\Support\Facades\Route;

Route::get('/ip/run/{ip}',function ($ip){

    $get = new IpController();
    $data = $get->get_location($ip);

    return response([
        "ip"=>$ip,
        "country"=>$data['country'],
        "city"=>$data['city'],
//        'insights'=> $data['insights']
    ],201);
});
