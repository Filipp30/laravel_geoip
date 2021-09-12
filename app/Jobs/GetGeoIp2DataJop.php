<?php

namespace App\Jobs;

use App\Http\Controllers\GeoIp2\GeoIp2Controller;

use App\Services\Contracts\GeoLocationContract;
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

    public function handle(GeoIp2Controller $geoIp2Controller)
    {
        $data = app(GeoLocationContract::class)->get_location($this->ip);
        $geoIp2Controller->send_to_admin($data);

    }

    public function failed(Throwable $exception,GeoIp2Controller $geoIp2Controller)
    {
        $geoIp2Controller->send_to_admin($exception);
    }

}
