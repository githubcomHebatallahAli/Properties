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

    // البحث عن المستخدم باستخدام رقم الهاتف
    $user = User::where('phoNum', $request->phoNum)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // البحث عن OTP المرتبط بالمستخدم
    $otpRecord = Otp::where('user_id', $user->id)
        ->where('otp', $request->otp)
        ->where('expires_at', '>', Carbon::now())
        ->first();

    if ($otpRecord) {
        // OTP صحيح وغير منتهي الصلاحية
        $user->update(['is_verified' => true]); // تحديث حالة المستخدم
        $otpRecord->delete(); // حذف OTP بعد التحقق منه
        return response()->json(['message' => 'OTP verified successfully'], 200);
    }

    return response()->json(['message' => 'Invalid or expired OTP'], 400);
}
}
