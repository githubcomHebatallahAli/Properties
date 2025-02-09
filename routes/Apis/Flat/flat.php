<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlatController;





Route::controller(FlatController::class)->group(
    function () {

   Route::get('/showAll/flat','showAll');
   Route::post('/create/flat', 'create');
   Route::get('/edit/flat/{id}','edit');
   Route::post('/update/flat/{id}', 'update');
   Route::delete('/delete/flat/{id}', 'destroy');
   Route::get('/showDeleted/flat', 'showDeleted');
Route::get('/restore/flat/{id}','restore');
Route::delete('/forceDelete/flat/{id}','forceDelete');
Route::patch('sold/flat/{id}', 'sold');
Route::patch('notSold/flat/{id}', 'notSold');
Route::patch('admin/active/flat/{id}', 'active')->middleware('admin');
Route::patch('admin/notActive/flat/{id}', 'notActive')->middleware('admin');
   });
