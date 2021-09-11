<?php

namespace App\Jobs;

use App\Http\Controllers\GeoIp2\GeoIp2Controller;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;


class GetGeoIp2DataJop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ip;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function handle(GeoIp2Controller $geoip2)
    {
        $data = $geoip2->get_location($this->ip);
        $geoip2->send_to_admin($data);
    }

    public function failed(Throwable $exception,GeoIp2Controller $geoip2)
    {
        $geoip2->send_to_admin($exception);
    }

}
