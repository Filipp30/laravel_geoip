<?php

namespace App\Notifications\GeoIp2Notifications;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioSmsMessage;

class GeoIpJobProcessedNotification extends Notification{
    use Queueable;

    public $attach_file;

    public function __construct($attach_file){
        $this->attach_file = $attach_file;
    }

    public function via($notifiable){
        return ['mail','database'];
//        return ['mail','database',TwilioChannel::class];
    }

    /**
     * @throws Exception
     */
    public function toMail($notifiable){
        if(file_exists($this->attach_file)){
            return (new MailMessage)
            ->subject('Geo Ip2 Job')
            ->greeting('Geo Ip2 Notification')
            ->line('Check attachment for data file.')
            ->line('Job called on : '.time())
            ->attach($this->attach_file);
        }else{
            throw new Exception('Attache file not found !!!');
        }
    }

    public function toDatabase(){
        return [
            'message'=>'GeoIp Job called on : '.time()
        ];
    }

    public function toTwilio($notifiable){
        return (new TwilioSmsMessage())
        ->content('GeoIp Job called on : '.time());
    }

    public function toArray($notifiable){
        return [
            //
        ];
    }
}
