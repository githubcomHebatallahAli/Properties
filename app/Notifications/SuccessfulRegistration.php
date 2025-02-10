<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\VonageMessage;

class SuccessfulRegistration extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */


     private $otp;
     private $firstName;

     public function __construct($otp, $firstName)
     {
         $this->otp = $otp;
         $this->firstName = $firstName;
     }

     public function via($notifiable)
     {
         return ['vonage'];
     }



    public function toVonage($notifiable)
    {
        return (new VonageMessage())
            ->content("Hello {$this->firstName}, your OTP code is: {$this->otp}")
            ->from(config('services.vonage.from'));
    }
}
