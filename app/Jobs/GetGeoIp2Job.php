<?php

namespace App\Jobs;

use App\Http\Controllers\GeoIp2\GeoIp2Controller;
use App\Models\AdminUsers;
use App\Notifications\GeoIp2Notifications\GeoIpJobFailedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class GetGeoIp2Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ip;

    public function __construct($ip){
        $this->ip = $ip;
    }

    public function handle( GeoIp2Controller $geoIp2Controller){
        $geoIp2Controller->handle($this->ip);
    }

    public function failed(Throwable $exception){
        $user = AdminUsers::query()->findOrFail(1);
        $user->notify(new GeoIpJobFailedNotification($exception));
    }
}
