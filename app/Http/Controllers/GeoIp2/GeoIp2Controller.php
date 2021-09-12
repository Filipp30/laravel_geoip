<?php

namespace App\Http\Controllers\GeoIp2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GeoIp2Controller extends Controller
{
    public function send_to_admin($data){
        $subject = "ip_data notification on : ";
        $file_name = 'log_time_'.time().'.txt';
        $log_file = fopen($file_name,'w');
        fwrite($log_file, json_encode($data));
        fclose($log_file);

        Mail::send('./email_templates/notification',$data,function($message) use ($file_name, $subject){
            $message->attach($file_name);
            $message->to('filipp-tts@outlook.com');
            $message->subject($subject);
        });
        unlink('./'.$file_name);
    }

    public function update(){

    }
}
