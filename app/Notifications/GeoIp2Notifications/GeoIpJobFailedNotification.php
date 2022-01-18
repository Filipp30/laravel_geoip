<?php

namespace App\Notifications\GeoIp2Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeoIpJobFailedNotification extends Notification
{
    use Queueable;

    public $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Geo Ip2 Job Failed!')
            ->line('Exception :')
            ->line($this->exception);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
