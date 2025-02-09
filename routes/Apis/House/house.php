<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;





Route::controller(HouseController::class)->group(
    function () {

   Route::get('/showAll/house','showAll');
   Route::post('/create/house', 'create');
   Route::get('/edit/house/{id}','edit');
   Route::post('/update/house/{id}', 'update');
   Route::delete('/delete/house/{id}', 'destroy');
   Route::get('/showDeleted/house', 'showDeleted');
Route::get('/restore/house/{id}','restore');
Route::delete('/forceDelete/house/{id}','forceDelete');
Route::patch('sold/house/{id}', 'sold');
Route::patch('notSold/house/{id}', 'notSold');
Route::patch('admin/active/house/{id}', 'active')->middleware('admin');
Route::patch('admin/notActive/house/{id}', 'notActive')->middleware('admin');
   });
