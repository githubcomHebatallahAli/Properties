<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficeController;





Route::controller(OfficeController::class)->group(
    function () {

   Route::get('/showAll/office','showAll');
   Route::post('/create/office', 'create');
   Route::get('/edit/office/{id}','edit');
   Route::post('/update/office/{id}', 'update');
   Route::delete('/delete/office/{id}', 'destroy');
   Route::get('/showDeleted/office', 'showDeleted');
Route::get('/restore/office/{id}','restore');
Route::delete('/forceDelete/office/{id}','forceDelete');
Route::patch('sold/office/{id}', 'sold');
Route::patch('notSold/office/{id}', 'notSold');
Route::patch('admin/active/office/{id}', 'active')->middleware('admin');
Route::patch('admin/notActive/office/{id}', 'notActive')->middleware('admin');
   });
