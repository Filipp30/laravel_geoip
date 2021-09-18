<?php

namespace App\Http\Controllers\GeoIp2;

use App\Http\Controllers\Controller;
use App\Models\AdminUsers;
use App\Notifications\GeoIp2Notifications\GeoIpJobProcessedNotification;
use App\Services\Contracts\GeoLocationContract;

class GeoIp2Controller extends Controller{

    public function handle($ip){
        $data = $this->getData($ip);
        $attach_file = $this->createFile($data);
        $this->notifyAdmin($attach_file);
        unlink('./'.$attach_file);
    }

    public function getData($ip){
        return app(GeoLocationContract::class)->get_location($ip);
    }

    public function createFile($data){
        $file_name = 'log_time_'.time().'.txt';
        $log_file = fopen($file_name,'w');
        fwrite($log_file, json_encode($data));
        fclose($log_file);
        return $file_name;
    }

    public function notifyAdmin($attach_file){
        return AdminUsers::query()->findOrFail(1)->notify(new GeoIpJobProcessedNotification($attach_file));
    }

}
