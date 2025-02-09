<?php

namespace App\Notifications;

use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Illuminate\Bus\Queueable;
use Vonage\Client\Credentials\Basic;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class SuccessfulRegistration extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */


     private $otp;
     private $name;

     public function __construct($otp, $name)
     {
         $this->otp = $otp;
         $this->name = $name;
     }

     public function via($notifiable)
     {
         return ['vonage'];  
     }

     public function toVonage($notifiable)
     {
         return new SMS(
             $notifiable->phoNum,
             env('VONAGE_FROM'),
             "Hello {$this->name}, your OTP code is: {$this->otp}"
         );
     }
}
