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

class GetGeoIp2Job implements ShouldQueue{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 1;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 15;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;



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
