<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\OwnerAuthController;
use App\Http\Controllers\Auth\BrokerAuthController;





Route::controller(AdminAuthController::class)->prefix('/admin')->group(
    function () {
Route::post('/login', 'login');
Route::post('/register',  'register');
Route::post('/logout',  'logout');
Route::post('/refresh', 'refresh');
Route::get('/user-profile', 'userProfile');

});
Route::controller(UserAuthController::class)->prefix('/user')->group(
    function () {
Route::post('/login', 'login');
Route::post('/register',  'register');
Route::post('/logout',  'logout');
Route::post('/refresh', 'refresh');
Route::get('/user-profile', 'userProfile');

});

Route::controller(OwnerAuthController::class)->prefix('/owner')->group(
    function () {
Route::post('/login', 'login');
Route::post('/register',  'register');
Route::post('/logout',  'logout');
Route::post('/refresh', 'refresh');
Route::get('/user-profile', 'userProfile');

});

Route::controller(BrokerAuthController::class)->prefix('/broker')->group(
    function () {
Route::post('/login', 'login');
Route::post('/register',  'register');
Route::post('/logout',  'logout');
Route::post('/refresh', 'refresh');
Route::get('/user-profile', 'userProfile');

});
