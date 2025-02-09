<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Ichtrojan\Otp\Otp;
use Illuminate\Notifications\Messages\VonageMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public string $message;
    public string $subject;
    private Otp $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        // الرسالة والعنوان الخاصين بالبريد الإلكتروني
        $this->message = 'Use the below OTP code to reset your password.';
        $this->subject = 'Reset Password';
        $this->otp = new Otp();  // تأكد من أنك تستخدم الحزمة الصحيحة
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        $channels = [];

        // التحقق إذا كان البريد الإلكتروني موجودًا
        if (!empty($notifiable->email)) {
            $channels[] = 'mail';
        }

        // التحقق إذا كان رقم الهاتف موجودًا
        if (!empty($notifiable->phoNum)) {
            $channels[] = 'vonage';  // استخدم Vonage لإرسال رسالة نصية
        }

        return $channels;
    }

    public function toMail($notifiable)
    {
        try {
            // توليد OTP باستخدام البريد الإلكتروني
            $otpData = $this->otp->generate($notifiable->email, 'numeric', 6, 60);  // 6 أرقام فقط لمدة 60 ثانية
            $otpCode = $otpData->token;
        } catch (\Exception $e) {
            return (new MailMessage)
                ->subject('Error generating OTP')
                ->line('There was an error generating your OTP code: ' . $e->getMessage());
        }

        // إرسال البريد الإلكتروني
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting('Hello ' . $notifiable->firstName)
            ->line($this->message)
            ->line('Your OTP code is: ' . $otpCode);
    }

    public function toVonage($notifiable)
    {
        try {
            // توليد OTP باستخدام رقم الهاتف
            $otpData = $this->otp->generate($notifiable->phoNum, 'numeric', 4, 60);  // 6 أرقام فقط لمدة 60 ثانية
            $otpCode = $otpData->token;
        } catch (\Exception $e) {
            return (new VonageMessage)
                ->content('There was an error generating your OTP code: ' . $e->getMessage());
        }

        // إرسال رسالة نصية عبر Vonage
        return (new VonageMessage)
            ->content('Your OTP code is: ' . $otpCode);
    }

}


