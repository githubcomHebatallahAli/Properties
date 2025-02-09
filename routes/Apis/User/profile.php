<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserProfileController;





Route::controller(UserProfileController::class)->group(
    function () {
        Route::post('/update/profile/{id}', 'updateProfile');
        Route::post('/update/profilePhoto/{id}', 'updateProfilePhoto');
    });
