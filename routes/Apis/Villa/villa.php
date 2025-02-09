<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillaController;





Route::controller(VillaController::class)->group(
    function () {

   Route::get('/showAll/villa','showAll');
   Route::post('/create/villa', 'create');
   Route::get('/edit/villa/{id}','edit');
   Route::post('/update/villa/{id}', 'update');
   Route::delete('/delete/villa/{id}', 'destroy');
   Route::get('/showDeleted/villa', 'showDeleted');
Route::get('/restore/villa/{id}','restore');
Route::delete('/forceDelete/villa/{id}','forceDelete');
Route::patch('sold/villa/{id}', 'sold');
Route::patch('notSold/villa/{id}', 'notSold');
Route::patch('admin/active/villa/{id}', 'active')->middleware('admin');
Route::patch('admin/notActive/villa/{id}', 'notActive')->middleware('admin');
   });
