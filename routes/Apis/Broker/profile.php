<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Broker\BrokerProfileController;






Route::controller(BrokerProfileController::class)->group(
    function () {
        Route::post('/update/profile/{id}', 'updateProfile');
        Route::post('/update/profilePhoto/{id}', 'updateProfilePhoto');
    });
