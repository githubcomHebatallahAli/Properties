<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Broker\BrokerDashboardController;






Route::controller(BrokerDashboardController::class)->group(
    function () {
        Route::get('/edit/properties/{id}', 'editProperties');
    });
