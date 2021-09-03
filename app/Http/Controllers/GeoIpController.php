<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeoIpController extends Controller{

    public function run(Request $request){
        logs()->info($request->get('data'));
        logs()->info($request['data']);
        logs()->info('Call run GeoIp...');
        return response([
            "message"=>'geo_ip_call',
            "data_1"=>$request->get('data'),
            "data_2"=>$request['data'],
        ]);
    }

}
