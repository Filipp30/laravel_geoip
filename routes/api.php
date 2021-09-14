<?php


use App\Http\Controllers\Storage\StorageController;
use App\Http\Controllers\VpsServer\ServerTaskController;
use App\Jobs\GetGeoIp2DataJop;
use Illuminate\Support\Facades\Route;

//This request will be redirected by proxy server from port 80 to localhost port 8000
Route::get('/ip/run/{ip}',function ($ip){
        GetGeoIp2DataJop::dispatch($ip);
        return response(["ip"=>$ip],201);
});

Route::get('/run/task/clean/log',[ServerTaskController::class,'rm_log_files']);



//SFTP Storage Routes
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
