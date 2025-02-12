<?php

namespace App\Notifications;

use App\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// use Ichtrojan\Otp\Otp;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $otp;
    private $firstName;
    private $emailOrPhone;

    public function __construct($otp, $firstName, $emailOrPhone)
    {
        $this->otp = $otp;
        $this->firstName = $firstName;
        $this->emailOrPhone = $emailOrPhone;
    }

    public function via($notifiable)
    {
        return filter_var($this->emailOrPhone, FILTER_VALIDATE_EMAIL) ? ['mail'] : ['vonage'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Your Password')
            ->greeting("Hello {$this->firstName},")
            ->line("Use this OTP to reset your password: **{$this->otp}**")
            ->line("This OTP is valid for 10 minutes.");
    }

    public function toVonage($notifiable)
    {
        return (new VonageMessage())
            ->content("Hello {$this->firstName}, your OTP code is: {$this->otp}")
            ->from(config('services.vonage.from'));
    }


}


