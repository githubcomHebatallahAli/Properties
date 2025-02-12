<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Rules\LoginExistsInTablesRule;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('phoNum', $request->login)
                    ->orWhere('email', $request->login)
                    ->first();

        $admin = Admin::where('phoNum', $request->login)
                      ->orWhere('email', $request->login)
                      ->first();

        $account = $user ?? $admin;

        if (!$account) {
            return response()->json(['error' => 'User or Admin not found.'], 404);
        }

        $otpRecord = Otp::where('user_id', $account->id)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            return response()->json(['error' => 'Invalid or expired OTP.'], 400);
        }

        $account->update(['password' => Hash::make($request->password)]);

        $otpRecord->delete();

        return response()->json(['message' => 'Password reset successfully.'], 200);
    }
}
