<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\BrokerController;



Route::controller(BrokerController::class)->group(
    function () {
        Route::get('/showAll/brokers', 'showAll');
        Route::get('/edit/broker/profile/{id}', 'editBrokerProfile');
    });
