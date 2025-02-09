<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\SelectedPropertyController;




Route::controller(SelectedPropertyController::class)->group(
    function () {
        Route::get('/show/latest/properties', 'getLatestProperties');
    });
