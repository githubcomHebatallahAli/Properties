<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicController;




Route::controller(ClinicController::class)->group(
    function () {

   Route::get('/showAll/clinic','showAll');
   Route::post('/create/clinic', 'create');
   Route::get('/edit/clinic/{id}','edit');
   Route::post('/update/clinic/{id}', 'update');
   Route::delete('/delete/clinic/{id}', 'destroy');
   Route::get('/showDeleted/clinic', 'showDeleted');
Route::get('/restore/clinic/{id}','restore');
Route::delete('/forceDelete/clinic/{id}','forceDelete');
Route::patch('sold/clinic/{id}', 'sold');
Route::patch('notSold/clinic/{id}', 'notSold');
Route::patch('admin/active/clinic/{id}', 'active')->middleware('admin');
Route::patch('admin/notActive/clinic/{id}', 'notActive')->middleware('admin');
   });
