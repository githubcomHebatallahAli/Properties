<?php

namespace App\Http\Controllers\Auth;

use Ichtrojan\Otp\Otp;

use Vonage\Client\Credentials\Basic;
use Vonage\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerfiyOTPRequest;
use App\Http\Requests\Auth\VerficationPhoNumRequest;

class VerficationController extends Controller
{
    private $otp;

    public function __construct()
    {
        $this->otp = new Otp();
    }



    public function sendOtp(VerficationPhoNumRequest $request)
{
    try {
        $phoNum = strval($request->phoNum);

        // التحقق من تنسيق الرقم
        if (!preg_match('/^\+\d{10,15}$/', $phoNum)) {
            throw new \Exception('Invalid phone number format.');
        }

        $otp = $this->otp->generate($phoNum, 6, 10); // توليد الرمز

        // رسالة OTP
        $otpMessage = "Your OTP is: " . $otp->token;

        // إرسال الرسالة
        $this->sendSms($phoNum, $otpMessage);

        return response()->json([
            'message' => 'OTP sent successfully.',
            'identifier' => $phoNum,
        ]);
    } catch (\Exception $e) {
        Log::error("Failed to send OTP: " . $e->getMessage());

        return response()->json([
            'message' => 'Failed to send OTP. Please try again later.',
            'error' => $e->getMessage(),
        ], 500);
    }
}





    public function resendOtp(VerficationPhoNumRequest $request)
    {
        // $validatedData = $request->validate([
        //     'phoNum' => 'required|string',
        // ]);


        Log::info("Generating OTP for {$request->phoNum}");
        $otp = $this->otp->generate($request->phoNum, 6, 10);
        Log::info("Generated OTP: ", ['otp' => $otp]); // كود من 6 أرقام صالح لمدة 10 دقائق


        try {
            $this->sendSms($request->phoNum, "Your OTP is: " . $otp->token);

            return response()->json([
                'message' => 'OTP resent successfully.',
                'identifier' => $request->phoNum,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to resend OTP: " . $e->getMessage());

            return response()->json([
                'message' => 'Failed to resend OTP. Please try again later.',
            ], 500);
        }
    }

    /**
     * التحقق من كود OTP.
     */
    public function verifyOtp(VerfiyOTPRequest $request)
    {
        $otpValidation = $this->otp->validate($request->phoNum, $request->otp);

        if (!$otpValidation->status) {
            return response()->json([
                'message' => 'Invalid or expired OTP.',
            ], 400);
        }

        return response()->json([
            'message' => 'OTP verified successfully.',
        ]);
    }

    // public function sendSms($to, $message)
    // {
    //     $testNumbers = ['+201114990063', '+201030124015']; // قائمة أرقام الاختبار المسجلة
    //     $message = 'Hello, this is a test message using Vonage!';
    //     $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
    //     $client = new Client($basic);

    //     $response = $client->sms()->send(
    //         new \Vonage\SMS\Message\SMS($to, env('VONAGE_FROM'), $message)
    //     );

    //     $message = $response->current();

    //     if ($message->getStatus() == 0) {
    //         return 'Message sent successfully.';
    //     } else {
    //         return 'Message failed with status: ' . $message->getStatus();
    //     }
    // }

    public function sendSms($to, $message)
{
    try {
        $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $client = new Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($to, env('VONAGE_FROM'), $message)
        );

        $messageStatus = $response->current();

        if ($messageStatus->getStatus() == 0) {
            Log::info("SMS sent successfully to {$to}");
            return 'Message sent successfully.';
        } else {
            Log::error("Failed to send SMS to {$to}. Status: " . $messageStatus->getStatus());
            return 'Message failed with status: ' . $messageStatus->getStatus();
        }
    } catch (\Exception $e) {
        Log::error("Error sending SMS: " . $e->getMessage());
        return 'Failed to send SMS. Error: ' . $e->getMessage();
    }
}

}
