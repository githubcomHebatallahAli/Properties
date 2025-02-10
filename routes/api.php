<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\TestController;
require __DIR__ . '/Apis/Auth/auth.php';
require __DIR__ . '/Apis/Auth/verification.php';
require __DIR__ . '/Apis/Auth/resetPassword.php';
require __DIR__ . '/Apis/Admin/role.php';
require __DIR__ . '/Apis/Admin/contact.php';
require __DIR__ . '/Apis/User/contact.php';
require __DIR__ . '/Apis/User/rating.php';
require __DIR__ . '/Apis/User/broker.php';
require __DIR__ . '/Apis/User/selectedProperty.php';
require __DIR__ . '/Apis/Chalet/chalet.php';
require __DIR__ . '/Apis/Clinic/clinic.php';
require __DIR__ . '/Apis/Flat/flat.php';
require __DIR__ . '/Apis/Villa/villa.php';
require __DIR__ . '/Apis/Shop/shop.php';
require __DIR__ . '/Apis/Land/land.php';
require __DIR__ . '/Apis/Office/office.php';
require __DIR__ . '/Apis/House/house.php';
require __DIR__ . '/Apis/Broker/dashboard.php';
require __DIR__ . '/Apis/Broker/profile.php';
require __DIR__ . '/Apis/test.php';


// Route::get('/test', [TestController::class, 'test']);

// use Vonage\Client;
// use Vonage\Client\Credentials\Basic;
// use Vonage\SMS\Message\SMS;

// Route::get('/test-sms', function () {
//     $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
//     $client = new Client($basic);

//     $response = $client->sms()->send(
//         new SMS("201114990063", env('VONAGE_FROM', 'Vonage'), 'اختبار من Laravel!')
//     );

//     $sms = $response->current();
// return response()->json([
//     'to' => $sms->getTo(),
//     'message_id' => $sms->getMessageId(),
//     'status' => $sms->getStatus(),
//     'remaining_balance' => $sms->getRemainingBalance(),
//     'message_price' => $sms->getMessagePrice(),
//     'network' => $sms->getNetwork(),
// ]);

// });

