<?php

namespace App\Notifications\Channels;


use Illuminate\Notifications\Notification;
use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Vonage\Client\Credentials\Basic;




class VonageChannel
{

    protected $client;

    // Constructor لتخزين العميل من Vonage
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification)
    {
        // الحصول على الرسالة من الإشعار
        $message = $notification->toVonage($notifiable);

        // التأكد من أن الرسالة هي كائن من نوع SMS
        if ($message instanceof SMS) {
            $this->client->sms()->send($message);
        }
    }



}
