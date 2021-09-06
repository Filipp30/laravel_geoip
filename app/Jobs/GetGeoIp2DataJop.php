<?php

namespace App\Jobs;

use App\Http\Controllers\GeoIp2\GeoIp2Controller;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        $this->send_to_admin($data);
    }

    public function send_to_admin($data){
        $subject = "ip_data notification on : ";
        $log_file = fopen('log.txt','w');
        fwrite($log_file, json_encode($data));
        fclose($log_file);

        Mail::send('./email_templates/notification',$data,function($message) use ($subject){
            $message->attach('./log.txt');
            $message->to('filipp-tts@outlook.com');
            $message->subject($subject);
        });
        unlink('./log.txt');
    }

    public function failed(Exception $exception)
    {
        logs()->info($exception);
    }

}
