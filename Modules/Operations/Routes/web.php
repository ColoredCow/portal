<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('operations')->group(function () {
    Route::get('/office-location', 'OperationsController@index')->name('office-location.index');
    Route::post('/office-location', 'OperationsController@store')->name('office-location.store');
    Route::get('/office-location/{centre}', 'OperationsController@edit')->name('office-location.edit');
    Route::put('/office-location/{centre}', 'OperationsController@update')->name('office-location.update');
    Route::delete('/office-location/{centre}', 'OperationsController@delete')->name('office-location.delete');
});
