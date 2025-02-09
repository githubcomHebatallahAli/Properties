<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SuccessfulRegistration;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Resources\Auth\UserRegisterResource;

class UserAuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phoNum';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = auth()->guard('api')->user();

        if ($user->ip !== $request->ip()) {
            $user->ip = $request->ip();
            $user->save();
        }

        $user->update([
            'last_login_at' => Carbon::now()->timezone('Africa/Cairo')
        ]);

        return $this->createNewToken($token);
    }

    public function register(UserRegisterRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $otp = mt_rand(1000, 9999);
        $expiresAt = Carbon::now()->addMinutes(10);


        $UserData = array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['ip' => $request->ip()],
            ['userType' => $request->userType ?? 'User']
        );

        $User = User::create($UserData);
        $otp = mt_rand(1000, 9999);
        $expiresAt = Carbon::now()->addMinutes(10);
        Otp::create([
            'user_id' => $User->id,
            'otp' => $otp,
            'expires_at' => $expiresAt,
        ]);
        $User->notify(new SuccessfulRegistration($otp,$User->firstName));


            return response()->json([
                'message' => 'User registration successful. Please verify your phone number.',
                'User' => new UserRegisterResource($User),
                'otp_identifier' => $User->phoNum,
            ], 201);
            return response()->json([
                'message' => 'User registration successful. However, OTP could not be sent. Please try resending it.',
                'User' => new UserRegisterResource($User),
                'error' => $e->getMessage(),
            ], 201);
        }


    public function logout()
    {
        $user = auth()->guard('api')->user();

        if ($user->last_login_at) {
            $sessionDuration = Carbon::parse($user->last_login_at)->diffInSeconds(Carbon::now());

            $user->update([
                'last_logout_at' => Carbon::now(),
                'session_duration' => $sessionDuration
            ]);
        }

        auth()->guard('api')->logout();

        return response()->json([
            'message' => 'User successfully signed out',
            'last_logout_at' => Carbon::now()->toDateTimeString(),
            'session_duration' => gmdate("H:i:s", $sessionDuration)
        ]);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->guard('api')->refresh());
    }

    public function userProfile()
    {
        return response()->json([
            "data" => auth()->guard('api')->user()
        ]);
    }

    protected function createNewToken($token)
    {
        $user = auth()->guard('api')->user();
        $user->last_login_at = Carbon::parse($user->last_login_at)
            ->timezone('Africa/Cairo')->format('Y-m-d H:i:s');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }

}
