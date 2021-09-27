<?php

namespace App\Jobs;

use App\Http\Controllers\GeoIp2\GeoIp2Controller;
use App\Models\User;
use App\Notifications\GeoIp2Notifications\GeoIpJobFailedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class HandleIpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $failOnTimeout = true;

    public $tries = 1;

    public $maxExceptions = 1;

    public $timeout = 15;

    protected $ip;

    public function __construct($ip){
        $this->ip = $ip;
    }

    public function handle(GeoIp2Controller $geoIp2Controller){
        $geoIp2Controller->handleIp($this->ip);
    }

    public function failed(Throwable $exception){
        $user = User::findOrFail(1);
        $user->notify(new GeoIpJobFailedNotification($exception));
    }
}
