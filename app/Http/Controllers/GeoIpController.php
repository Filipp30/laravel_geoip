<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeoIpController extends Controller{

    public function run(Request $request){
        logs()->info($request);
        logs()->info('Call run GeoIp...');
        return response([
            "message"=>'geo_ip_call'
        ]);
    }

}
