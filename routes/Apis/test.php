<?php


use App\Models\User;
use Illuminate\Support\Facades\Route;

use Vonage\Client\Credentials\Basic;
use Vonage\Client;

use App\Http\Resources\Auth\UserRegisterResource;
use App\Http\Controllers\Auth\VerficationController;

Route::get('/test-user', function () {
    $user = User::find(7); // ابحث عن المستخدم بالـ ID المطلوب
    return new UserRegisterResource($user); // أعد البيانات في شكل JSON
});

Route::get('/send-sms', function () {
    $to = '+201114990063'; // رقم المستلم
    $message = 'Hello from Laravel using Vonage!';
    return app()->make(VerficationController::class)->sendSms($to, $message);
});

