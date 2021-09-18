<?php

use App\Http\Controllers\Storage\StorageController;
use App\Http\Controllers\VpsServer\ServerTaskController;
use App\Jobs\GetGeoIp2DataJop;
use App\Jobs\GetGeoIp2Job;
use Illuminate\Support\Facades\Route;

//NGINX:This request will be redirected by proxy server from port 80 to localhost port 8000
Route::get('/ip/run/{ip}',function ($ip){
       GetGeoIp2Job::dispatch($ip);
       return response(["ip"=>$ip],201);
});



//SFTP: Storage Routes # SFTP server created on the VPS server
Route::post('/save/file',[StorageController::class,'put']);

Route::get('/exists/{dir}/{file_name}',function($dir,$file_name,StorageController $storage){
   return $storage->exists($dir,$file_name);
});
Route::get('/download/{dir}/{file_name}',function ($dir,$file_name,StorageController $storage){
    return $storage->download($dir,$file_name);
});
Route::delete('/delete/{dir}/{file_name}',function ($dir,$file_name,StorageController $storage){
    return $storage->delete($dir,$file_name);
});


//VPS-server: Run bash script #home/exdir/run.sh  on the server
Route::get('/run/task/rm/log',[ServerTaskController::class,'rm_log']);
Route::get('/run/task/ping/{ip}',function ($ip,ServerTaskController $serverTaskController){
    return $serverTaskController->ping_ip($ip);
});
