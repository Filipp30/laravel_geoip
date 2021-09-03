<?php

use App\Http\Controllers\GeoIpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/geo/ip/run',[GeoIpController::class,'run']);
