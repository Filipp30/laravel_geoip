<?php

namespace App\Http\Controllers\Redis;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;


class RedisController extends Controller{


    public function run(){

        Redis::set('name', 'Filipp');
        $res = Redis::get('name');

        return response([
            'message'=>'Redis run',
            'redis_response'=>$res
        ],201);
    }


}
