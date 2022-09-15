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

Route::prefix('revenue-proceeds')->group(function () {
    Route::get('/', 'RevenueProceedController@index')->name('revenue.proceeds.index');
    Route::post('/store', 'RevenueProceedController@store')->name('revenue.proceeds.store');
    Route::post('/update/{id}', 'RevenueProceedController@update')->name('revenue.proceeds.update');
    Route::get('/delete/{id}', 'RevenueProceedController@delete')->name('revenue.proceeds.delete');
});
