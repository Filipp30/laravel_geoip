<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Storage\StorageController;
use App\Http\Controllers\VpsServer\ServerTaskController;
use App\Jobs\HandleIpJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Nginx: Save Ip address when visiting th web-site.
    Route::get('/ip/run/{ip}',function ($ip){
        HandleIpJob::dispatch($ip);
        return response(['ip'=>$ip],201);
    });


//SFTP: Storage Routes # SFTP server created on the VPS server.
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


//VPS-server: Run bash script #home/exedir/run.sh  on the server.
    Route::get('/run/task/rm/log',[ServerTaskController::class,'rm_log']);
    Route::get('/run/task/ping/{ip}',function ($ip,ServerTaskController $serverTaskController){
        return $serverTaskController->ping_ip($ip);
    });
    ### Task: database handler ###
    Route::get('/run/task/create/database',[ServerTaskController::class,'create_database']);


//AUTH: Authentication and Authorization routes.
    Route::post('/auth/registration',[RegistrationController::class,'registration']);

    ### Email Verification ###
    Route::get('/email/verify/{id}/{hash}',[EmailVerificationController::class,'emailVerify'])
    ->middleware(['auth.email.verification'])->name('verification.verify');

    Route::get('/email/verification-notification/{id}',[EmailVerificationController::class,'sendEmailVerificationNotification'])
    ->name('verification.send');


    ### Login Logout ### ---> php artisan passport:client --password
    Route::post('/login',[LoginController::class,'login'])->middleware(['passport.login']);
    Route::post('/refresh',[LoginController::class,'refresh']);
    Route::post('/logout',[LoginController::class,'logout'])->middleware('auth:api');
    Route::get('/user', function (Request $request) { return $request->user();})->middleware('auth:api');


