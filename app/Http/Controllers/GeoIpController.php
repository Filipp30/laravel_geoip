<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeoIpController extends Controller{

    public function run(Request $request){
        logs()->info(json_encode($request));
        logs()->info(json_encode($request->get('data')));
        logs()->info('Call run GeoIp...');
        return response([
            "message"=>'geo_ip_call',
            "request"=>gettype($request)
        ]);
    }

}
