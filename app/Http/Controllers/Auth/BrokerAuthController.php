<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Broker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\BrokerRegisterRequest;
use App\Http\Resources\Auth\BrokerRegisterResource;
use App\Http\Requests\Auth\VerficationPhoNumRequest;

class BrokerAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->guard('broker')->attempt($validator->validated())) {
            return response()->json([
                'message' => 'Invalid data'
            ], 422);

        }

        $broker = auth()->guard('broker')->user();

        // if (!$broker->is_verified) {
        //     return response()->json([
        //         'message' => 'Your account is not verified. Please verify your phone number.'
        //     ], 403);
        // }

        if ($broker->ip !== $request->ip()) {
            $broker->ip = $request->ip();
            $broker->save();
        }

        $broker->update([
            'last_login_at' => Carbon::now()->timezone('Africa/Cairo')
        ]);

        return $this->createNewToken($token);
    }


    public function register(BrokerRegisterRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store(Broker::PHOTO_FOLDER);
            // dd($photoPath);
        }

        $brokerData = array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['ip' => $request->ip()],
            ['userType' => $request->userType ?? 'broker']
        );

        if (isset($photoPath)) {
            $brokerData['photo'] = $photoPath;
        }

        $broker = Broker::create($brokerData);

        // if ($request->hasFile('media')) {

        //     $path = $request->file('media')->store('broker', 'public');
        //     $broker->media()->create(['path' => $path]);
        // }

        // $broker->load('media');

        // $broker->save();
        // $broker->notify(new EmailVerificationNotification());
        try {
            $verificationController = new VerficationController();

            $request = new VerficationPhoNumRequest(['phoNum' => $broker->phoNum]);

            $verificationController->sendOtp($request);

            return response()->json([
                'message' => 'Broker registration successful. Please verify your phone number.',
                'broker' => new BrokerRegisterResource($broker),
                'otp_identifier' => $broker->phoNum,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Broker registration successful. However, OTP could not be sent. Please try resending it.',
                'broker' => new BrokerRegisterResource($broker),
                'error' => $e->getMessage(),
            ], 201);
        }
        return response()->json([
            'message' => 'Broker Registration successful',
            'broker' =>new BrokerRegisterResource($broker)
        ]);
    }


    public function logout()
    {

        $broker = auth()->guard('broker')->user();

        if ($broker->last_login_at) {
            $sessionDuration = Carbon::parse($broker->last_login_at)->diffInSeconds(Carbon::now());

            $broker->update([
                'last_logout_at' => Carbon::now(),
                'session_duration' => $sessionDuration
            ]);
        }
        auth()->guard('broker')->logout();

        return response()->json([
            'message' => 'Broker successfully signed out',
            'last_logout_at' => Carbon::now()->toDateTimeString(),
            'session_duration' => gmdate("H:i:s", $sessionDuration)
        ]);
    }


    public function refresh()
    {
        return $this->createNewToken(auth()->guard('broker')->refresh());
    }


    public function userProfile()
    {
        return response()->json([
            "data" => auth()->guard('broker')->user()
        ]);
    }


    protected function createNewToken($token)
    {
        // $broker = auth()->guard('broker')->user();
        // $broker->last_login_at = Carbon::parse($broker->last_login_at)
        // ->timezone('Africa/Cairo')->format('Y-m-d H:i:s');
        // $broker = Broker::find(auth()->guard('broker')->id());
        $broker = auth()->guard('broker')->user();
        $broker->last_login_at = Carbon::parse($broker->last_login_at)
        ->timezone('Africa/Cairo')->format('Y-m-d H:i:s');
        return response()->json([

            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('broker')->factory()->getTTL() * 60,
            'broker' => auth()->guard('broker')->user(),
            // 'broker' => $broker,
        ]);
    }



}
