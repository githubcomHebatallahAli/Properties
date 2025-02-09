<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;





Route::controller(ShopController::class)->group(
    function () {

   Route::get('/showAll/shop','showAll');
   Route::post('/create/shop', 'create');
   Route::get('/edit/shop/{id}','edit');
   Route::post('/update/shop/{id}', 'update');
   Route::delete('/delete/shop/{id}', 'destroy');
   Route::get('/showDeleted/shop', 'showDeleted');
Route::get('/restore/shop/{id}','restore');
Route::delete('/forceDelete/shop/{id}','forceDelete');
Route::patch('sold/shop/{id}', 'sold');
Route::patch('notSold/shop/{id}', 'notSold');
Route::patch('admin/active/shop/{id}', 'active')->middleware('admin');
Route::patch('admin/notActive/shop/{id}', 'notActive')->middleware('admin');
   });
