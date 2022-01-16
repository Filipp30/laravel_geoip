<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Http\Request;

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
