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


        // $otpCode = rand(100000, 999999);
        $otpCode = mt_rand(1000, 9999);

        Otp::updateOrCreate(
            ['identifier' => $input],
            ['otp' => $otpCode, 'expires_at' => now()->addMinutes(10)]
        );

        if ($user) {
            $user->notify(new ResetPasswordNotification($otpCode, $user->name, $input));
        }

        if ($admin) {
            $admin->notify(new ResetPasswordNotification($otpCode, $admin->name, $input));
        }

        return response()->json([
            'message' => "Please check your SMS or email."
        ]);
    }


}
