<?php

use App\Http\Controllers\GeoIp2\GeoIp2Controller;
use App\Jobs\GetGeoIp2DataJop;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

Route::get('/ip/run/{ip}',function ($ip){

        GetGeoIp2DataJop::dispatch($ip);
            return response([
            "geo_ip2"=>"job called",
            "ip"=>$ip
        ],201);
    });

    Route::get('/run/task/clean/log',function (){
//        $process = new Process(['whoami']);
        $process = new Process(['/home/exdir/run.sh']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return response([
            "shell-command"=>"cleanLogFiles",
            "status"=>$process->getOutput(),
            "error"=>$process,

        ],201);
    });
