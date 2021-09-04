<?php

use Illuminate\Support\Facades\Route;

Route::get('/ip/run/{ip}',function ($ip){
    return response([
        "message"=>'run_ip_call',
        "ip"=>$ip,
    ],201);
});
