<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Broker\RatingController;




Route::controller(RatingController::class)->group(
    function () {
        Route::post('/create/rating&comment', 'create');
    });
