<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;

use Vonage\Client;
use App\Models\Otp;
// use Ichtrojan\Otp\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Vonage\Client\Credentials\Basic;
use App\Http\Requests\Auth\VerfiyOTPRequest;
use App\Notifications\SuccessfulRegistration;
use App\Http\Requests\Auth\VerficationPhoNumRequest;

class VerficationController extends Controller
{

    public function verifyOtp(Request $request)
{
    $request->validate([
        'phoNum' => 'required|string',
        'otp' => 'required|string',
    ]);

    $user = User::where('phoNum', $request->phoNum)->first();

    if (!$user) {
        return response()->json([
            'message' => 'User not found'
        ]);
    }

    $otpRecord = Otp::where('user_id', $user->id)
        ->where('otp', $request->otp)
        ->where('expires_at', '>', Carbon::now())
        ->first();

    if ($otpRecord) {
        $user->update(['is_verified' => true]);
        $otpRecord->delete();
        return response()->json([
            'message' => 'OTP verified successfully'
        ]);
    }

    return response()->json([
        'message' => 'Invalid or expired OTP'
    ]);
}

public function resendOtp(Request $request)
{
    $request->validate([
        'phoNum' => 'required|string',
    ]);

    $user = User::where('phoNum', $request->phoNum)->first();

    if (!$user) {
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    // التحقق من آخر OTP تم إرساله خلال الدقيقة الأخيرة
    $lastOtp = Otp::where('user_id', $user->id)
        ->where('created_at', '>', Carbon::now()->subMinute()) // دقيقة واحدة فقط
        ->first();

    if ($lastOtp) {
        return response()->json([
            'message' => 'Please wait before requesting a new OTP',
        ], 429); // HTTP 429: Too Many Requests
    }

    // إنشاء OTP جديد
    $otp = mt_rand(1000, 9999);
    $expiresAt = Carbon::now()->addMinutes(10);

    // حفظ OTP الجديد في قاعدة البيانات
    Otp::updateOrCreate(
        ['user_id' => $user->id],
        [
            'otp' => $otp,
            'expires_at' => $expiresAt,
            'created_at' => Carbon::now() // تحديث وقت الإنشاء لمنع التكرار
        ]
    );

    // إرسال OTP الجديد عبر الإشعارات
    try {
        $user->notify(new SuccessfulRegistration($otp, $user->first_name));

        return response()->json([
            'message' => 'OTP resent successfully',
            'otp_identifier' => $user->phoNum,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to resend OTP',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
