<?php

namespace App\Http\Controllers\Auth;

use App\Models\Otp;
use App\Models\User;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Notifications\ResetPasswordNotification;
use App\Http\Requests\Auth\ForgetPasswordRequest;

class ForgetPasswordController extends Controller
{

    public function forgotPassword(ForgetPasswordRequest $request)
    {
        $input = $request->login;

        $user = User::where('phoNum', $input)->orWhere('email', $input)->first();
        $admin = Admin::where('phoNum', $input)->orWhere('email', $input)->first();

        if (!$user && !$admin) {
            return response()->json(['message' => "User or Admin not found."], 404);
        }

        $otpCode = rand(1000, 9999);

        Otp::updateOrCreate(
            [
                'user_id' => $user ? $user->id : null,
                'admin_id' => $admin ? $admin->id : null,
            ],
            [
                'otp' => $otpCode,
                'expires_at' => now()->addMinutes(10),
            ]
        );

        $firstName = $user ? $user->name : $admin->name;
        $emailOrPhone = $user ? ($user->email ?? $user->phoNum) : ($admin->email ?? $admin->phoNum);

        // إرسال الإشعار مع البيانات الصحيحة
        if ($user) {
            $user->notify(new ResetPasswordNotification($otpCode, $firstName, $emailOrPhone));
        } else {
            $admin->notify(new ResetPasswordNotification($otpCode, $firstName, $emailOrPhone));
        }

        return response()->json([
            'message' => "Please check your SMS or email."
        ]);
    }
}
