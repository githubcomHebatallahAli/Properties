<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandController;





Route::controller(LandController::class)->group(
    function () {

   Route::get('/showAll/land','showAll');
   Route::post('/create/land', 'create');
   Route::get('/edit/land/{id}','edit');
   Route::post('/update/land/{id}', 'update');
   Route::delete('/delete/land/{id}', 'destroy');
   Route::get('/showDeleted/land', 'showDeleted');
Route::get('/restore/land/{id}','restore');
Route::delete('/forceDelete/land/{id}','forceDelete');
Route::patch('sold/land/{id}', 'sold');
Route::patch('notSold/land/{id}', 'notSold');
Route::patch('admin/active/land/{id}', 'active')->middleware('admin');
Route::patch('admin/notActive/land/{id}', 'notActive')->middleware('admin');
   });
